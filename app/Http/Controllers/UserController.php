<?php
/**
 * Created by PhpStorm.
 * User: Jarvis
 * Date: 2017/8/11 0011
 * Time: 16:19
 */

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;


class UserController extends Controller
{
    public function updateUserAction(Request $request)
    {
        $name = $request->get('name');
        $email = $request->get('email');

        if(!filter_var($email, FILTER_VALIDATE_EMAIL) || $name == '')
            return array(
                "result" => 0,
                "data" => "It's not a valid email/name."
            );

        $res = \DB::table('users')
                    ->where('id', $_SESSION['id'])
                    ->update(['name' => $name,
                                'email' => $email]);

        if($res == 0)
            return array(
                "result" => 0,
                "data" => "Make some changes before update."
            );

        $_SESSION['name'] = $name;
        $_SESSION['email'] = $email;
        return array(
            "result" => 1
        );
    }

    public function updatePasswordAction(Request $request){
        $password = $request->get("password");
        $user = $this->getUserById($_SESSION['id']);
        if($user == null || $user->password != $password)
            return array(
                "result" => 0,
                "data" => "Password is wrong."
            );

        $newPass = $request->get("newPass");
        if(!preg_match("/^[a-zA-Zd_]{8,}$/",$newPass))
            return array(
                "result" => 0,
                "data" => "Password is invalid."
            );

        \DB::table('users')
            ->where('id', $_SESSION['id'])
            ->update(['password' => $newPass]);

        return array(
            "result" => 1
        );
    }

    public function deleteUser($id)
    {
        $user = User::find($id);
        $user->delete();
        return response()->json('Deleted');
    }

    public function getUserById($id)
    {
        $user = \DB::table('users')->where('id', $id)->first();
        return $user;
    }

    public function getUserByEmail($email){
        $user = \DB::table('users')->where('email', $email)->first();
        return $user;
    }

    public function createUserAction(Request $request)
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

        if(!preg_match("/^(\\w){6,20}$/",$password))
            return array(
                "result" => 0,
                "data" => "Password is invalid."
            );

        $user =  $this->getUserByEmail($email);
        if($user != null)
            return array(
                "result" => 0,
                "data" => "Email exists, try to Login?"
            );

        $user = User::create($request->all());
        return array(
            "result" => 1,
            "data" => $user
        );
    }

    public function loginAction(Request $request){
        $email = $request->get("email");
        $user = \DB::table('users')->where('email', $email)->first();

        if($user == null)
            return array(
                "result" => 0,
                "data" => "Login fail"
            );

        $password = $request->get("password");
        if($user->password == $password){
            $_SESSION['id'] = $user->id;
            $_SESSION['name'] = $user->name;
            $_SESSION['email'] = $user->email;
            $_SESSION['role'] = $user->role;
            return array(
                "result" => 1,
                "data" => $user
            );
        }else{
            return array(
                "result" => 0,
                "data" => "Login fail"
            );
        }
    }

    public function getUserAction(Request $request){
        $user = User::find($_SESSION['id']);
        return view('profile_user', ['user' => $user]);
    }

    public function logoutAction(){
        session_unset();
        session_destroy();
        return redirect("/");
    }
}