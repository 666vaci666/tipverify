<?php

namespace App\Policies;

use App\Models\Tip;
use App\Models\User;

class TipPolicy
{
    public function update(User $user, Tip $tip): bool
{
    return $user->is_admin;
}

public function delete(User $user, Tip $tip): bool
{
    return $user->is_admin;
}
}