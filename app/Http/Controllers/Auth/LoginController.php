<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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
    protected function authenticated(Request $request, $user)
    {
        if ($user->hasRole('coordinator') && $user->is_approved_coordinator) {
            // Als de gebruiker een 'coordinator' is en geapproveerd, stuur ze dan naar de admin-pagina
            return redirect('/admin/approvals');
        } else if ($user->hasRole('lid') && !$user->is_approved_member) {
            // Als de gebruiker een lid is maar nog niet is goedgekeurd, log ze dan uit en stuur ze naar de 'approval pending'-pagina
            $this->guard()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/approval-pending');
        } else if ($user->hasRole('opdrachtgever') && !$user->is_approved_client) {
            // Als de gebruiker een opdrachtgever is maar nog niet is goedgekeurd, log ze dan uit en stuur ze naar de 'approval pending'-pagina
            $this->guard()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/approval-pending');
        } else if ($user->hasRole('lid') && $user->is_approved_member) {

            return redirect('/member/open-assignments');
        } else if ($user->hasRole('opdrachtgever') && $user->is_approved_client) {

            return redirect('/client/task');
        }
    }



    // protected function authenticated(Request $request, $user)
    // {
    //     if (! $user->is_approved) {
    //         $this->guard()->logout();

    //         $request->session()->invalidate();

    //         $request->session()->regenerateToken();

    //         return redirect('/approval-pending');
    //     }
    // }
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
