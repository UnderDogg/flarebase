<?php
namespace Modules\Core\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Modules\Core\Models\Role;
use Modules\Core\Models\Settings;
use Modules\Core\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Session;
use Auth;
use Modules\Core\Requests\Setting\UpdateSettingOverallRequest;
use Modules\Core\Services\Setting\SettingServiceContract;
use Modules\Core\Services\Role\RoleServiceContract;

class SettingsController extends Controller
{

    protected $settings;
    protected $roles;

    public function __construct(
        SettingServiceContract $settings,
        RoleServiceContract $roles
    )
    {
        $this->settings = $settings;
        $this->roles = $roles;
        $this->middleware('user.is.admin', ['only' => ['index']]);
    }

    public function index()
    {
        return view('settings.index')
            ->withSettings($this->settings->getSetting())
            ->withPermission($this->roles->allPermissions())
            ->withRoles($this->roles->allRoles());
    }

    public function updateOverall(UpdateSettingOverallRequest $request)
    {
        $this->settings->updateOverall($request);
        Session::flash('flash_message', 'Overall settings successfully updated');
        return redirect()->back();
    }

    public function permissionsUpdate(Request $request)
    {
        $this->roles->permissionsUpdate($request);
        Session::flash('flash_message', 'Role is updated');
        return redirect()->back();
    }
}
