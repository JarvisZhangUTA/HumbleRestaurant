<?php
/**
 * Created by PhpStorm.
 * User: Jarvis
 * Date: 2017/8/11 0011
 * Time: 0:55
 */

namespace App\Http\Controllers;

use App\TokenCode;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;


class TokenCodeController extends Controller
{

    function createTokenCode($type){
        $code = $this->createRandomStr(50);

        \DB::table('token_codes')->insert(
            ['code' => $code, 'type' => $type]
        );

        return $code;
    }

    function getTokenCode($type, $code){
        $tokenCode = \DB::table('token_codes')
            ->where('code', $code)
            ->first();

        if($tokenCode == null || $tokenCode->type != $type)
            return false;

        \DB::table('token_codes')->where('code', $code)->delete();
        return true;
    }

    function createRandomStr($length)
    {
        $rand = '';
        for ($i = 0; $i < $length; $i++)
        {
            $rand .= chr(mt_rand(65,90));
        }
        return $rand;
    }
}