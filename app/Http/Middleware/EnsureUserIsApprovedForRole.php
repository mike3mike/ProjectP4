<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class EnsureUserIsApprovedForRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]  ...$roles
     * @return mixed
     */
    // public function handle($request, Closure $next, ...$roles)
    // {
    //     $user = Auth::user();

    //     foreach ($roles as $role) {
    //         // Zorg ervoor dat de rol bestaat in de mapping.
    //         if (!isset($user->role_approval_mapping[$role])) {
    //             continue;
    //         }

    //         $isApprovedAttribute = $user->role_approval_mapping[$role];
    //         if (!$user->{$isApprovedAttribute}) {
    //             return redirect('home')->with('error', 'Je bent niet goedgekeurd voor de rol: ' . $role);
    //         }
    //     }

    //     return $next($request);
    // }
    public function handle(Request $request, Closure $next, ...$roles)
{
    if (!$request->user()) {
        return redirect()->route('login');
    }

    foreach ($roles as $role) {
        // print the role
        // dd($role);

        $approvalAttribute = $request->user()->getApprovalAttributeForRole($role);

        // print the approval attribute
        // dd($approvalAttribute);

        // check if the user has the role and is approved for it
        if (!$request->user()->hasRole($role)) {
            return redirect()->route('member.openAssignments.index')->with('warning', 'Je moet de rol van ' . $role . ' hebben om deze pagina te bekijken.');
        }

        if (!$request->user()->$approvalAttribute) {
            return redirect()->route('member.openAssignments.index')->with('warning', 'Je rol van ' . $role . ' moet worden goedgekeurd voordat je deze pagina kunt bekijken.');
        }
       
    }

    return $next($request);
}

}
