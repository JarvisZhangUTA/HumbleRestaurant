<?php
/**
 * Created by PhpStorm.
 * User: Jarvis
 * Date: 2017/8/11 0011
 * Time: 0:55
 */

namespace App\Http\Controllers;

use App\User;
use App\Restaurant;
use App\Http\Controllers\RatingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RestaurantController extends Controller
{
    public function updateRestaurantAction(Request $request)
    {
        $id = $request->get('id');
        $name = $request->get('restaurantName');
        $address = $request->get('address');
        $percentageDonation = $request->get('percentageDonation');
        $summary = $request->get('summary');
        $phone = $request->get('phone');
        $info = $request->get('info');
        $fund = $request->get('fund');

        $lat = $request->get('lat');
        $lng = $request->get('lng');

        $res = \DB::table('restaurants')
            ->where('id', $id)
            ->update(['name' => $name,
                'longitude' => $lng,
                'latitude' => $lat,
                'address' => $address,
                'summary' => $summary,
                'fund' => $fund,
                'percentageDonation' => $percentageDonation,
                'phone' => $phone,
                'info' => $info
            ]);

        if($res == 0)
            return array(
                "result" => 0,
                "data" => "Make some changes before update."
            );

        return array(
            "result" => 1,
            "id" => $id
        );
    }

    public function deleteRestaurant($id)
    {
        $restaurant = Restaurant::find($id);
        $restaurant->delete();
        return response()->json('Deleted');
    }

    public function getRestaurantAction($id){
        $restaurant = \DB::table('restaurants')->where('id', $id)->first();
        $images = \DB::select('select url from images where rid = :id', ['id' => $id]);

        $ratingController = new RatingController();
        $ratings = $ratingController->getRestaurantRatings($id,1);

        return view('restaurant',
            ['restaurant' => $restaurant,
                'images' => $images,
                'ratings' => $ratings
            ]);
    }

    public function editRestaurantAction($id){
        if($id == "0")
            $restaurant =  \DB::table('restaurants')->where('uid', $_SESSION['id'])->first();
        else
            $restaurant =  \DB::table('restaurants')->where('id', $id)->first();

        return view('profile_restaurant',['restaurant' => $restaurant]);
    }

    public function editRestaurantImgAction($id){
        $images = \DB::select('select url from images where rid = :id', ['id' => $id]);
        $default = \DB::select('select url from restaurants where id = :id', ['id' => $id]);
        $default = $default[0]->url;

        return view('profile_restaurant_img', ['id' => $id, 'images' => $images, 'default' => $default]);
    }

    public function defaultRestaurantImgAction(Request $request, $id){
        $url = $request->get('url');
        \DB::table('restaurants')
            ->where('id', $id)
            ->update(['url' => $url]);

        return array("result" => 1);
    }

    public function uploadRestaurantImgAction(Request $request,$id){
        $input = $request->file("img_file");
        Storage::disk('local')->put('images', $input);

        \DB::table('images')->insert([
            ['rid' => $id,
                'url' => 'storage/images/'.$input->hashName()]
        ]);

        if(\DB::table('restaurants')->where('id', $id)->first()->url == '')
            \DB::table('restaurants')
                ->where('id', $id)
                ->update(['url' => 'storage/images/'.$input->hashName()]);


        return redirect("/profileRestaurantImgPage.".$id);
    }

    public function deleteRestaurantImgAction(Request $request, $id){
        $url = $request->get("url");
        Storage::disk('local')->delete(substr($url,8));

        if(\DB::table('restaurants')->where('id', $id)->first()->url == $url)
            \DB::table('restaurants')
                ->where('id', $id)
                ->update(['url' => '']);

        \DB::table('images')->where('url', '=', $url)->delete();
        return array("result" => 1);
    }

    public function createRestaurantAction(Request $request)
    {
        $email = $request->get("email");
        if(!filter_var($email, FILTER_VALIDATE_EMAIL))
            return array(
                "result" => 0,
                "data" => "It's not a valid email address."
            );

        $password = $request->get("password");
        if($password == "" || $email == "")
            return array(
                "result" => 0,
                "data" => "Values can't be null."
            );

        $lat = $request->get('lat');
        $lng = $request->get('lng');
        if($lat == '' || $lng == '')
            return array(
                "result" => 0,
                "data" => "Cannot locate the Address."
            );

        $userController = new UserController();
        $user =  $userController->getUserByEmail($email);
        if($user != null)
            return array(
                "result" => 0,
                "data" => "Email exists, try to Login?"
            );

        $name = $request->get('name');
        $address = $request->get('address');
        $summary = $request->get('summary');

        if($name == '' || $address == '' || $summary == '')
            return array(
                "result" => 0,
                "data" => "Values can't be null."
            );

        $id = \DB::table('users')->insertGetId(
            ['name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => $request->get('password'),
                'role' => $request->get('role')]
        );

        \DB::table('restaurants')->insert([
            ['name' => $request->get('name'),
                'summary' => $request->get('summary'),
                'address' => $request->get('address'),
                'longitude' => $lng,
                'latitude' => $lat,
                'uid' => $id]
        ]);

        return array(
            "result" => 1
        );
    }

    public function getPagesAction(){
        $nums = \DB::select('select count(*) from restaurants');
        $nums = $nums[0]->{'count(*)'};
        $pages = (int) ($nums % 9 == 0 ? $nums / 9 : $nums / 9 + 1);

        $restaurants = \DB::select('SELECT * FROM restaurants ORDER BY rating DESC LIMIT 0, 9');

        return view('main', ['pages' => $pages, 'restaurants' => $restaurants]);
    }

    public function indexAction($page = 2)
    {
        $restaurants = \DB::select('SELECT * FROM restaurants ORDER BY rating DESC LIMIT '.(($page - 1)*9).','.($page*9));

        return array(
            'result' => 1,
            'data' =>['restaurants' => $restaurants]
        );
    }

    public function searchPageAction($lat,$lng,$search,$page,$miles){
        $info_sql = "select * from restaurants ";
        if($lat != "" && $lng != "") {
            $squares = $this->returnSquarePoint($lng, $lat,$miles);
            $info_sql .= "where latitude<>0
            and latitude>{$squares['right-bottom']['lat']} 
            and latitude<{$squares['left-top']['lat']} 
            and longitude>{$squares['left-top']['lng']} 
            and longitude<{$squares['right-bottom']['lng']} ";
        }

        if($search != "null"){
            $info_sql .= "and name like '%$search%'";
        }

        $restaurants = \DB::select($info_sql.' ORDER BY rating DESC LIMIT '.(($page - 1)*9).','.($page*9));

        return view('search', ['restaurants' => $restaurants,
            'search' => $search,
            'lat' => $lat,'lng' => $lng, 'page' => $page, 'miles' => $miles]);
    }

    public function searchAction(Request $request){

        $latFrom = $request->get('latFrom');
        $latTo = $request->get('latTo');
        $lngFrom = $request->get('lngFrom');
        $lngTo = $request->get('lngTo');
        $search = $request->get('search');
        $page = $request->get('page');

        $latMin = min($latFrom,$latTo);
        $latMax = max($latFrom,$latTo);
        $lngMin = min($lngFrom,$lngTo);
        $lngMax = max($lngFrom,$lngTo);

        $info_sql = "select * from restaurants ";
        $info_sql .= "where latitude between $latMin and $latMax and longitude between $lngMin and $lngMax ";

        if($search != "null"){
            $info_sql .= "and name like '%$search%'";
        }

        $restaurants = \DB::select($info_sql.' ORDER BY rating DESC LIMIT '.(($page - 1)*10).','.($page*10));

        return array(
            'restaurants' => $restaurants
        );
    }

    function returnSquarePoint($lng, $lat,$distance = 20){
        $EARTH_RADIUS = 6371;

        $dlng =  2 * asin(sin($distance / (2 * $EARTH_RADIUS)) / cos(deg2rad($lat)));
        $dlng = rad2deg($dlng);

        $dlat = $distance/$EARTH_RADIUS;
        $dlat = rad2deg($dlat);

        return array(
            'left-top'=>array('lat'=>$lat + $dlat,'lng'=>$lng-$dlng),
            'right-top'=>array('lat'=>$lat + $dlat, 'lng'=>$lng + $dlng),
            'left-bottom'=>array('lat'=>$lat - $dlat, 'lng'=>$lng - $dlng),
            'right-bottom'=>array('lat'=>$lat - $dlat, 'lng'=>$lng + $dlng)
        );
    }
}