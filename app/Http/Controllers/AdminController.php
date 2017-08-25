<?php
/**
 * Created by PhpStorm.
 * User: Jarvis
 * Date: 2017/8/11 0011
 * Time: 0:55
 */

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;


class AdminController extends Controller
{

    public function sendEmailAction(Request $request)
    {
        $email = $request->get('email');
        if(!filter_var($email, FILTER_VALIDATE_EMAIL))
            return array(
                "result" => 0,
                "data" => "It's not a valid email address."
            );

        $user =  \DB::table('users')->where('email', $email)->first();
        if($user != null)
            return array(
                "result" => 0,
                "data" => "Email exists as ".$user->role
            );

        $tokenCodeController = new TokenCodeController();
        $code = $tokenCodeController->createTokenCode("signUp");
        Mail::send('emails.registerRestaurant', ['code' => $code], function($message)
            use ($email)
        {
            $message->to($email, '')->subject('Invitation from Humble Restaurant');
        });

        return array(
            "result" => 1
        );
    }

    public function verifyCodeAction($code){
        $tokenCodeController = new TokenCodeController();

        if($code == 0 && isset($_SESSION['role']) && $_SESSION['role'] == 'admin')
            return view("restaurant_sign_up");

        if($tokenCodeController->getTokenCode('signUp',$code)) {
            return view("restaurant_sign_up");
        }else {
            return redirect("/");
        }
    }


}