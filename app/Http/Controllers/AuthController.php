<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class AuthController extends Controller
{

    /**
     * Auth login
     *
     * @param  Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' =>  'required|email',
            'password'    =>  'required|string',
        ]);

        $apiToken = Crypt::encryptString($request->email.';'.$request->password);

        return $apiToken;
    }


    public function decrypt(Request $request)
    {
        try {
            $decrypted = Crypt::decryptString($request->token);

            return $decrypted;
        } catch (DecryptException $e) {
            //
        }
    }
}
