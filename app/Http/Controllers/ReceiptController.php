<?php
namespace App\Http\Controllers;

use App\User;
use App\Restaurant;
use App\Http\Controllers\RatingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReceiptController extends Controller
{
    public function uploadReceiptAction(Request $request){
        $uid = $request->get('uid');
        $rid = $request->get('rid');
        $amount = $request->get('amount');
        $date = $request->get('date');
        $file = $request->file('uploadFile');

        Storage::disk('local')->put('receipts', $file);

        $percentageDonation = \DB::select('SELECT percentageDonation FROM restaurants where id = '.$rid);
        $percentageDonation = $percentageDonation[0]->percentageDonation;

        \DB::table('receipts')->insert([
            ['rid' => $rid,
                'uid' => $uid,
                'amount' => $amount,
                'donation' => $amount * $percentageDonation / 100,
                'date' => $date,
                'verified' => false,
                'url' => 'storage/receipts/'.$file->hashName()]
        ]);

        return array(
            'result' => 1
        );
    }

    public function getReceiptAction(Request $request){
        $page = $request->get('page');

        if(!isset($_SESSION['role']))
            return redirect('/');

        if($_SESSION['role'] == 'admin'){
            $sql = 'SELECT * FROM receipts ORDER BY date DESC LIMIT '.(($page - 1)*10).','.($page*10);
        }else if($_SESSION['role'] == 'restaurant'){
            $rid = \DB::select('SELECT id FROM restaurants where uid = '.$_SESSION['id']);
            $rid = $rid[0]->id;

            $sql = 'SELECT * FROM receipts WHERE rid = '.$rid.' ORDER BY date DESC LIMIT '.(($page - 1)*10).','.($page*10);
        }else{
            $sql = 'SELECT * FROM receipts WHERE uid = '.$_SESSION['id'].' ORDER BY date DESC LIMIT '.(($page - 1)*10).','.($page*10);
        }

        $receipts = \DB::select($sql);
        return array(
            'receipts' => $receipts
        );
    }

    public function getReceiptPage(){
        $page = 1;
        if(!isset($_SESSION['role']))
            return redirect('/');

        if($_SESSION['role'] == 'admin'){
            $sql = 'SELECT * FROM receipts ORDER BY date DESC LIMIT '.(($page - 1)*10).','.($page*10);
        }else if($_SESSION['role'] == 'restaurant'){
            $rid = \DB::select('SELECT id FROM restaurants where uid = '.$_SESSION['id']);
            $rid = $rid[0]->id;

            $sql = 'SELECT * FROM receipts WHERE rid = '.$rid.' ORDER BY date DESC LIMIT '.(($page - 1)*10).','.($page*10);
        }else{
            $sql = 'SELECT * FROM receipts WHERE uid = '.$_SESSION['id'].' ORDER BY date DESC LIMIT '.(($page - 1)*10).','.($page*10);
        }

        $receipts = \DB::select($sql);
        return view("profile_receipt",['receipts' => $receipts]);
    }

    public function deleteReceiptAction(Request $request){
        $id = $request->get('id');
        $url = \DB::select('SELECT url FROM receipts where id = '.$id);
        $url = $url[0]->url;

        Storage::disk('local')->delete(substr($url,8));
        \DB::table('receipts')->where('id', '=', $id)->delete();

        return array(
            'result' => 1
        );
    }

    public function verifyReceiptAction(Request $request){
        $id = $request->get('id');
        \DB::table('receipts')
            ->where('id', $id)
            ->update(['verified' => 1]);

        $res = \DB::select('SELECT uid,rid,donation FROM receipts where id = '.$id);
        $rid = $res[0]->rid;
        $donation = $res[0]->donation;
        $uid = $res[0]->uid;

        \DB::update('update restaurants set fund = fund - ? , donation = donation + ? where id = ?',
            [$donation,$donation,$rid]);

        \DB::update('update users set donation = donation + ? where id = ?',
            [$donation,$uid]);

        return array(
            'result' => 1
        );
    }

    public function getDonationRankAction(){
        $restaurants = \DB::select("SELECT * FROM restaurants ORDER BY donation DESC LIMIT 0, 10");
        $users = \DB::select("SELECT * FROM users WHERE role='user' ORDER BY donation DESC LIMIT 0, 10");

        $res = \DB::select("SELECT SUM(donation) as donation, SUM(amount) as payment FROM receipts");

        return view('donation_rank',[
            "restaurants" => $restaurants,
            "users" => $users,
            "donation" => $res[0]->donation,
            "payment" => $res[0]->payment
        ]);
    }
}