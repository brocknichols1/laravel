<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class RoleController extends Controller
{
    /**
     * 
     * @param User $user
     * @return view
     */
    public function index(User $user)
    {
        return view('role.index', compact('user'));
    }

    /**
     * 
     * @param User $user
     * @return view
     */
    public function edit(User $user)
    {
        return view('role.edit', compact('user'));
    }

    /**
     * Update a user's Role
     * @param Request $request
     * @param int $id
     * @return model
     */
    public function update(Request $request, int $id)
    {
        $role = Role::where('user_id', '=', $id)->firstOrFail();
        $role->update($request->all());

        return $role;
    }
}
