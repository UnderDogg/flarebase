<?php
namespace App\Http\Middleware\Ticket;

use Closure;
use Modules\Core\Models\Settings;
use Modules\Core\Models\Ticket;

class CanTicketUpdateStatus
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
    $isAdmin = auth()->user()->hasRole('administrator');
    $settings = Settings::all();
    $settingscomplete = $settings[0]['ticket_complete_allowed'];
    if ($isAdmin) {
      return $next($request);
    }
    if ($settingscomplete == 1 && auth()->user()->id != $ticket->assigned_to_staff_id) {
      Session()->flash('flash_message_warning', 'Only assigned user are allowed to close Ticket.');
      return redirect()->back();
    }
    return $next($request);
  }
}
