<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::User();
        if ($user->hasRole('coordinator')) {
            // Als de gebruiker een 'coordinator' is, stuur ze dan naar de admin-pagina
            return redirect('/admin/approvals');
        } else if ($user->hasRole('lid') && !$user->is_approved_member) {
            // Als de gebruiker een lid is maar nog niet is goedgekeurd, log ze dan uit en stuur ze naar de 'approval pending'-pagin
            return redirect('/approval-pending');
        } else if ($user->hasRole('opdrachtgever') && !$user->is_approved_client) {
            // Als de gebruiker een opdrachtgever is maar nog niet is goedgekeurd, log ze dan uit en stuur ze naar de 'approval pending'-pagina
            $this->guard()->logout();

            return redirect('/approval-pending');
        } else if ($user->hasRole('lid') && $user->is_approved_member) {

            return redirect('/member/open-assignments');
        } else if ($user->hasRole('opdrachtgever') && $user->is_approved_client) {

            return redirect('/client/task');
        }
    }
}
