<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */

    public function subscribe(User $user,User $subscribeto){
        $flag = true;
        foreach ($subscribeto->subscribers as $subscriber){
            if ($subscriber->id === $user->id){
                $flag = false;
            }
        }
        return $flag;
    }
}
