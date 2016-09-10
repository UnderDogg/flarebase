<?php
namespace Modules\Notifications\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Modules\Core\Models\Staff;
use Notifynder;

class NotificationsController extends Controller
{
    public function gtAll()
    {
        $user = Staff::find(\Auth::id());
        $notread = $user->getNotificationsNotRead();
        return $notread->toJson();
    }

    public function markRead(Request $request)
    {
        $notifyId = $request->Id;
        Notifynder::readOne($notifyId);
    }

    public function markAll()
    {
        $user = \Auth::id();
        Notifynder::readAll($user);
        return redirect()->back();
    }
}
