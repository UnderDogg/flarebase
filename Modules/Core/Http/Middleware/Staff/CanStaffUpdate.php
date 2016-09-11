<?php

namespace App\Http\Middleware\Staff;

use Closure;

class CanStaffUpdate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!auth()->user()->can('staff-update')) {
            Session()->flash('flash_message_warning', 'Not allowed to update staff');
            return redirect()->route('users.index');
        }
        return $next($request);
    }
}
