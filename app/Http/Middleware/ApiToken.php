<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class ApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            $decrypted = Crypt::decryptString($request->header('X-API-Token'));
            $data = explode(';', $decrypted, 2);

            if(isset($data[0]) && filter_var($data[0], FILTER_VALIDATE_EMAIL)) {
                $request->merge(array("user_email" => $data[0]));
                return $next($request);
            }
        } catch (DecryptException $e) {
            abort(403, 'Unauthorized action.');
        }
    }
}
