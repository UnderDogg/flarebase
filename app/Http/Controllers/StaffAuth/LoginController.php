<?php
namespace App\Http\Controllers\StaffAuth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/staffpanel';

    // if auth is user
    protected $redirectToUser = '/profile';
    /* Direct After Logout */
    protected $redirectAfterLogout = '/';
    protected $loginPath = '/login';


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('staff.auth.login');
    }


    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);
        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($lockedOut = $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }
        $credentials = $this->credentials($request);
        if ($this->guard()->attempt($credentials, $request->has('remember'))) {
            //$users[] = Auth::guard('staff')->user();
            //$users[] = Auth::guard()->user();
            $users[] = Auth::guard('staff')->user();
            $thisactualuser = Auth::guard('staff');
            //$temp = $thisactualuser->getAuthIdentifier();
            //$session = $thisactualuser->getSession();
            /*
            session(['key' => 'value']);
            // Or
            session()->put('key', 'value')
            Getting a value from a session
            $value = session()->get('key');
            // Alternatively you can pass in a default value
            $value = session()->get('key', 'default);
            */
            //dd($users);
            //$this->lastAttempted = $user = $this->provider->retrieveByCredentials($credentials);
            //dd(Auth::guard('staff')->getUser());
            //dd(Auth::guard('staff')->check());


            //This redirect below looks for the variable : redirectTo
            return redirect()->intended($this->redirectPath());
        }
        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        /*if (!$lockedOut) {
          $this->incrementLoginAttempts($request);
        }
        return $this->sendFailedLoginResponse($request);*/
    }

    /**
     * Log the user out of the application.
     *
     * @return Response
     */
    public function getLogout()
    {
        //Auth::logout();
        $this->auth->logout();
        return redirect('/guestindex');
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('staff');
    }
}
