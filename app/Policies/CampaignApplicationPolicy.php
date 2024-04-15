<?php

namespace App\Policies;

use App\Enums\AdminRoleEnum;
use App\Models\CampaignApplication;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CampaignApplicationPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CampaignApplication $campaignApplication): bool
    {
        if($user->hasRole(AdminRoleEnum::ADMIN->value)){
            return true;
        }
        return $user->id === $campaignApplication->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CampaignApplication $campaignApplication): bool
    {
        return $user->id === $campaignApplication->user_id;
    }

    public function cancel(User $user, CampaignApplication $campaignApplication): bool
    {
        return $user->id === $campaignApplication->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CampaignApplication $campaignApplication): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CampaignApplication $campaignApplication): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, CampaignApplication $campaignApplication): bool
    {
        //
    }
}
