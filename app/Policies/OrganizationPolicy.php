<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Organization;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrganizationPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        //
    }

    public function view(User $user, Organization $organization)
    {
        //
    }

    public function create(User $user)
    {
        //
    }

    public function update(User $user, Organization $organization)
    {
        return $user->id == $organization->user_id;
    }

    public function delete(User $user, Organization $organization)
    {
        //
    }

    public function restore(User $user, Organization $organization)
    {
        //
    }


    public function forceDelete(User $user, Organization $organization)
    {
        //
    }
}
