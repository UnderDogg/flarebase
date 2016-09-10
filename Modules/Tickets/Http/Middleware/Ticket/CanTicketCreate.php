<?php
namespace App\Http\Middleware\Ticket;

use Closure;

class CanTicketCreate
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
    dd(auth()->user()->can());
    if (!auth()->user()->can('ticket-create')) {
      Session()->flash('flash_message_warning', 'Not allowed to create ticket');
      return redirect()->route('users.index');
    }
    return $next($request);
  }
}
