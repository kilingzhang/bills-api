<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class User extends Model
{
    //
    public static function hasToken($token)
    {

        $value = 's:32:"' . $token . '";';

        $value = DB::table('cache')->where('value', $value)->first();


        if(empty($value)){
            return false;
        }

        $key  = $value->key;

        $username = explode('_',$key);


        $key = 'login_token_' . $username[4];


        $tokenOld = Cache::get($key);


        if (!empty($tokenOld) && $tokenOld === $token) {
            return true;
        } else {
            return false;
        }

    }
}
