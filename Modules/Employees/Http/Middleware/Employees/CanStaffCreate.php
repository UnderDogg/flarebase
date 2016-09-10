<?php
namespace App\Http\Middleware\Employees;

use Closure;

class CanStaffCreate
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
    if (!auth()->staff()->can('user-create')) {
      Session()->flash('flash_message_warning', 'Not allowed to create user');
      return redirect()->route('employees.index');
    }
    return $next($request);
  }
}
