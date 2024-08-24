<?php

namespace App\Policies;

use App\Enums\AdminRoleEnum;
use App\Models\Board;
use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PostPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Post $post): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Board $board): bool
    {
        if($user->hasRole(AdminRoleEnum::ADMIN->value) || $user->hasRole(AdminRoleEnum::SUPER_ADMIN->value)){
            return true;
        }

        if(!in_array($board->slug, ['free'])){
            return false;
        }

        return isset($user->id);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Post $post): bool
    {
        if($user->hasRole(AdminRoleEnum::ADMIN->value) || $user->hasRole(AdminRoleEnum::SUPER_ADMIN->value)){
            return true;
        }

        return $user->id === $post->user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Post $post): bool
    {
        if($user->hasRole(AdminRoleEnum::ADMIN->value) || $user->hasRole(AdminRoleEnum::SUPER_ADMIN->value)){
            return true;
        }

        return $user->id === $post->user->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Post $post): bool
    {
        if($user->hasRole(AdminRoleEnum::ADMIN->value) || $user->hasRole(AdminRoleEnum::SUPER_ADMIN->value)){
            return true;
        }
        return $user->id === $post->user->id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Post $post): bool
    {
        if($user->hasRole(AdminRoleEnum::ADMIN->value) || $user->hasRole(AdminRoleEnum::SUPER_ADMIN->value)){
            return true;
        }
        return $user->id === $post->user->id;
    }
}
