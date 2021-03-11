<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use App\Models\Address;
use App\Models\Role;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ProfilesController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @param User $user
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(User $user)
    {
        return view('profiles.index', compact('user'));
    }

    /**
     * 
     * @param User $user
     * @return view
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user->profile);
        return view('profiles.edit', compact('user'));
    }

    /**
     * Update values associated with a user's Profile
     * 
     * @param Request $request
     * @return array
     */
    public function update(Request $request): array
    {
        $user = User::findOrFail($request->id);
        $userName = $request->username ?? '';
        $user->update([
            'username' => $userName,
            'organization_id' => $request->organization_id,
        ]);
        
        $profile = Profile::where('user_id', '=', $user->id)->first();
        
        // Make sure there is a record
        if($profile) {
            $profile->update([
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'title' => $request->title,
                'description' => $request->description
            ]);
        }

        $address = Address::where('user_id', '=', $user->id)->first();
        
        if ($address) {
            $address->update([
                'street' => $request->street,
                'city' => $request->city,
                'state' => $request->state,
                'zip' => $request->zip,
            ]);
        }
        
        // Roles are only assigned by administrators. They cannot be changed by users
        if ($request->role) {
            // If there's no record, fail
            $role = Role::where('user_id', '=', $user->id)->firstOrFail();
            $role->update([
           'user_role' => $request->role, 
        ]);

        }
        
        $status = 'success';

        return compact('status', 'user', 'profile', 'address');

    }

}
