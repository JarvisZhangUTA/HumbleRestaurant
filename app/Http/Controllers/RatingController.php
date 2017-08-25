<?php
/**
 * Created by PhpStorm.
 * User: Jarvis
 * Date: 2017/8/11 0011
 * Time: 0:55
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\UserController;


class RatingController extends Controller
{

    public function addRatingAction(Request $request){
        if(!isset($_SESSION['id']))
            return array(
                'result' => 0,
                'data' => 'You need to login first'
            );

        $rid = $request->get('rid');
        $score = $request->get('score');
        $comment = $request->get('comment');

        if($rid == '')
            return array(
                'result' => 0,
                'data' => 'Error while replying.'
            );

        if($score == '0')
            return array(
                'result' => 0,
                'data' => 'Please leave a score.'
            );

        if($comment == '')
            return array(
                'result' => 0,
                'data' => 'Please leave some comment.'
            );

        $userController = new UserController();
        $user = $userController->getUserById($_SESSION['id']);

        $id = \DB::table('ratings')->insertGetId(
            ['uid' => ($user->id),
                'rid' => $rid,
                'score' => $score,
                'comment' => $comment,
                'name' => ($user->name),
                'created_at' => date('Y-m-d H:i:s')
            ]
        );

        $rating = \DB::table('ratings')->where('id', $id)->first();
        \DB::update("UPDATE restaurants 
          SET star".$score." = star".$score."+1 WHERE id = ".$rid);
        \DB::update("UPDATE restaurants 
          SET rating = (star1 + star2*2 + star3*3 + star4*4 + star5*5)
                        /(star1 + star2 + star3 + star4 + star5) WHERE id = ".$rid);

        return array(
            'result' => 1,
            'data' => $rating
        );
    }

    public function getRestaurantRatingsAction(Request $request){
        $rid = $request->get('rid');
        $page = $request->get('page');
        $arr = [
            'rid' => $rid,
            'sIndex' => (($page - 1)*10),
            'eIndex' => (($page) * 10)
        ];

        $ratings = \DB::select('SELECT * FROM ratings where rid = :rid ORDER BY created_at DESC LIMIT :sIndex,:eIndex', $arr);

        return array(
            'result' => 1,
            'data' => $ratings
        );
    }

    public function getRestaurantRatings($rid,$page){

        $arr = [
            'rid' => $rid,
            'sIndex' => (($page - 1)*10),
            'eIndex' => (($page) * 10)
        ];

        $ratings = \DB::select('SELECT * FROM ratings where rid = :rid ORDER BY created_at DESC LIMIT :sIndex,:eIndex', $arr);

        return $ratings;
    }
}