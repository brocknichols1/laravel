<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\User;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class AddressController extends Controller
{
    public function index(User $user)
    {
        return view('profiles.index', compact('user'));
    }

    public function edit(User $user)
    {
        //$this->authorize('update', $user->address);
        return view('profiles.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $address = Address::findOrFail($id);
        $address->update($request->all());

        return $address;
    }

}
