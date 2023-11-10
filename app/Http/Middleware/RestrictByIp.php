<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RestrictByIp
{
    protected $allowedIps = ['127.0.0.1', '58.69.124.93']; // Add your allowed IP(s) here


    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        Log::info('Request IP address: ' . $request->ip()); // Add this line to log the IP

        if (!in_array($request->ip(), $this->allowedIps)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return $next($request);
    }
}