<?php

namespace App\Actions\Fortify;

use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use App\Enums\RoleEnum;
use App\Enums\AdminRoleEnum;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        return DB::transaction(function () use ($input) {
            $role = $input['role'] ?? null;

            return tap(User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
            ]), function (User $user) use ($role){
                $this->createTeam($user);
                switch ($role){
                    case RoleEnum::BUSINESS_USER->value:
                        $user->assignRole(RoleEnum::BUSINESS_USER->value);
                        break;
                    case RoleEnum::VENDOR_USER->value:
                        $user->assignRole(RoleEnum::VENDOR_USER->value);
                        break;
                    case AdminRoleEnum::SUPER_ADMIN->value:
                        $user->assignRole(AdminRoleEnum::SUPER_ADMIN->value);
                        break;
                    case AdminRoleEnum::ADMIN->value:
                        $user->assignRole(AdminRoleEnum::ADMIN->value);
                        break;
                    case AdminRoleEnum::SALES_TEAM->value:
                        $user->assignRole(AdminRoleEnum::SALES_TEAM->value);
                        break;
                    case AdminRoleEnum::ACCOUNTING_TEAM->value:
                        $user->assignRole(AdminRoleEnum::ACCOUNTING_TEAM->value);
                        break;
                    case AdminRoleEnum::OPERATIONS_TEAM->value:
                        $user->assignRole(AdminRoleEnum::OPERATIONS_TEAM->value);
                        break;
                    default:
                        $user->assignRole(RoleEnum::GENERAL_USER->value);
                        break;
                }
            });
        });
    }

    /**
     * Create a personal team for the user.
     */
    protected function createTeam(User $user): void
    {
        $user->ownedTeams()->save(Team::forceCreate([
            'user_id' => $user->id,
            'name' => explode(' ', $user->name, 2)[0]."'s Team",
            'personal_team' => true,
        ]));
    }
}
