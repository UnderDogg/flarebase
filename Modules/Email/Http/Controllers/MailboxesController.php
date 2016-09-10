<?php
namespace Modules\Email\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Datatables;
use Config;
use Illuminate\Support\Facades\Auth;
use Modules\Core\Services\Setting\SettingServiceContract;

class MailboxesController extends Controller
{


    public function __construct()
    {
        $this->middleware('mailbox.create', ['only' => ['create']]);
        $this->middleware('mailbox.update', ['only' => ['edit']]);
    }

    public function index()
    {
        echo "guard staff (mailboxes controller index function)";
        //dd(Auth::guard('staff')->user());
        dd(Auth::guard()->user());
        return view('mailboxes.index');
    }
}