<?php

namespace App\Policies;

use App\Models\Usuario;
use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class UsuarioPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can manage users.
     *
     * @param  \App\Models\Usuario  $user
     * @return mixed
     */
    public function manageUsers(Usuario $user)
    {
        return Admin::where('usuario_id', $user->id)->exists();
    }
}
