<?php
namespace App\Http\Middleware\Relation;

use Closure;

class CanRelationUpdate
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
    if (!auth()->user()->can('relation-update')) {
      Session()->flash('flash_message_warning', 'Not allowed to update relation');
      return redirect()->route('admin.relations.relations.index');
    }
    return $next($request);
  }
}
