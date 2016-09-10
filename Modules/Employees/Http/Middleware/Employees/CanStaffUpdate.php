<?php
namespace App\Http\Middleware\Employees;

use Closure;

class CanStaffUpdate
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request $request
   * @param  \Closure $next
   * @return mixed
   */
  public function handle($request, Closure $next)
  {
    if (!auth()->staff()->can('user-update')) {
      Session()->flash('flash_message_warning', 'Not allowed to update user');
      return redirect()->route('employees.index');
    }
    return $next($request);
  }
}
