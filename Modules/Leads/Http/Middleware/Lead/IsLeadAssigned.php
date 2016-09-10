<?php

namespace App\Http\Middleware\Lead;

use Closure;
use Modules\Core\Models\Settings;
use Modules\Leads\Models\Leads;

class IsLeadAssigned
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
    $lead = Lead::findOrFail($request->id);
        $settings = Settings::all();
        $isAdmin = Auth()->user()->hasRole('administrator');
        $settingscomplete = $settings[0]['lead_assign_allowed'];
        if ($isAdmin) {
            return $next($request);
        }
        if ($settingscomplete == 1  && Auth()->user()->id == $lead->assigned_to_staff_id) {
            Session()->flash('flash_message_warning', 'Not allowed to create lead');
            return redirect()->back();
        }
        return $next($request);
    }
}
