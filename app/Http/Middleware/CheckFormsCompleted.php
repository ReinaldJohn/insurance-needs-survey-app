<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckFormsCompleted
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
        // Check if the necessary forms are completed (you can customize this logic)
        if (!$request->session()->get('form_submitted', false)) {
            // Redirect the user to the forms page if the forms are not completed
            return redirect()->route('insurance-needs.index');
        }
        return $next($request);
    }
}
