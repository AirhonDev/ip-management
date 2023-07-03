<?php

namespace App\Http\Middleware;

use App\Models\AuditLog;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogActivity
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
        $response = $next($request);


        if (Auth::check()) {  // Ensure the user is logged in.
            AuditLog::create([
                'ip_address' => $request->ip(),
                'user_id' => Auth::id(),
                'method' => $request->method(),
                'request_path' =>  $request->path(),
                'action_time' => now(),
                'payload' => json_encode($request->all()),
            ]);
        }

        return $response;
    }
}
