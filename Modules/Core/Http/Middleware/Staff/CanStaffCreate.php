<?php

namespace App\Http\Middleware\Staff;

use Closure;

class CanStaffCreate
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
        if (!auth()->user()->can('staff-create')) {
            Session()->flash('flash_message_warning', 'Not allowed to create staff');
            return redirect()->route('users.index');
        }
        return $next($request);
    }
}
