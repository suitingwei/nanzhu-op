<?php

namespace App\Http\Middleware;

use Closure;

class HttpBasicAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->getUser() != 'ansiod' || $request->getPassword() != 'peorgjp') {
            $headers = array('WWW-Authenticate' => 'Basic');
            return response('请先登录', 401, $headers);
        }
        return $next($request);
    }
}
