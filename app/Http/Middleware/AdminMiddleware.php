<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //jika akun yang login sesuai dengan role 
        //maka silahkan akses
        //jika tidak sesuai akan diarahkan ke home
        if (Auth::check()) {
            $roles = array_slice(func_get_args(), 2);

            foreach ($roles as $role) {
                $user = Auth::user()->level;
                if ($user == $role) {
                    return $next($request);
                }
            }
        }
        
        abort(403, 'Unauthorized action.');
        
        
        
    }
}
