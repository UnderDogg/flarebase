<?php
namespace App\Http\Middleware\Ticket;

use Closure;
use App\Models\Settings;
use App\Models\Ticket;

class IsTicketAssigned
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
    $ticket = Ticket::findOrFail($request->id);
    $settings = Settings::all();
    $isAdmin = Auth()->user()->hasRole('administrator');
    $settingscomplete = $settings[0]['ticket_assign_allowed'];
    if ($isAdmin) {
      return $next($request);
    }
    if ($settingscomplete == 1 && Auth()->user()->id != $ticket->assigned_to_staff_id) {
      Session()->flash('flash_message_warning', 'Only assigned user are allowed to do this');
      return redirect()->back();
    }
    return $next($request);
  }
}
