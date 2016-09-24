<?php

namespace App\Http\Middleware;

use Closure;

/**
 * CheckRoleStaff.
 *
 * @author      Ladybird <info@ladybirdweb.com>
 */
class CheckRoleStaff
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->user()->role == 'agent' || $request->user()->role == 'admin') {
            return $next($request);
        }

        return redirect('dashboard')->with('fails', 'You are not Authorized');
    }
}
