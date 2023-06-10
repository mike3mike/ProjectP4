<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Notifications\UserRoleApproved;
use App\Notifications\UserRoleDenied;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Client;
use App\Models\Address;

class RoleRequestController extends Controller
{
    public function index()
    {
        $users = User::where(function ($query) {
            $query->where(function ($query) {
                $query->whereHas('roles', function ($query) {
                    $query->where('name', 'lid');
                })->where('is_approved_member', false);
            })->orWhere(function ($query) {
                $query->whereHas('roles', function ($query) {
                    $query->where('name', 'opdrachtgever');
                })->where('is_approved_client', false);
            })->orWhere(function ($query) {
                $query->whereHas('roles', function ($query) {
                    $query->where('name', 'coordinator');
                })->where('is_approved_coordinator', false);
            });
        })->get();
    
        return view('admin.role-requests.index', compact('users'));
    }
    
    
    
    
    public function approve(User $user, Role $role)
    {
        $roleName = strtolower($role->name);
    
        $user->{"is_approved_Client"} = true;
       
        $user->save();

        $user->notify(new UserRoleApproved($role));

        return redirect()->route('admin.role-requests.index')->with('success', 'Rol aanvraag goedgekeurd.');
    }
    // public function deny(User $user, Role $role)
    // {
    //     $roleName = strtolower($role->name);
    //     $user->{"is_approved_Client"} = false;
    //     $user->save();
    
    //     $user->notify(new UserRoleDenied($role));
    
    //     return redirect()->route('admin.role-requests.index')->with('success', 'Rol aanvraag geweigerd.');
    // }
    public function deny(User $user, Role $role)
{
    $roleName = strtolower($role->name);
// dd($roleName);
    // Check if the role is 'opdrachtgever'
    if ($roleName == 'opdrachtgever') {
        // Get the user's client record
        $client = Client::where('user_id', $user->id)->first();

        if ($client) {
            // If the client has an associated address, delete it
            if ($client->address) {
                $client->address->delete();
            }

            // Delete the client record
            $client->delete();
        }
    }

    // Detach the role from the user
    $user->roles()->detach($role->id);

    $approvalAttribute = $user->getApprovalAttributeForRole($roleName);

    $user->$approvalAttribute = false;
    $user->save();

    $user->notify(new UserRoleDenied($role));

    return redirect()->route('admin.role-requests.index')->with('success', 'Rol aanvraag geweigerd.');
}

  
}
