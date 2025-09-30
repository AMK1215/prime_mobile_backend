<?php

namespace App\Policies;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CustomerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any customers.
     */
    public function viewAny(User $user)
    {
        return $user->hasRole('Owner') || $user->hasRole('SystemWallet');
    }

    /**
     * Determine whether the user can view the customer.
     */
    public function view(User $user, Customer $customer)
    {
        return $user->id === $customer->owner_id || $user->hasRole('SystemWallet');
    }

    /**
     * Determine whether the user can create customers.
     */
    public function create(User $user)
    {
        return $user->hasRole('Owner') || $user->hasRole('SystemWallet');
    }

    /**
     * Determine whether the user can update the customer.
     */
    public function update(User $user, Customer $customer)
    {
        return $user->id === $customer->owner_id || $user->hasRole('SystemWallet');
    }

    /**
     * Determine whether the user can delete the customer.
     */
    public function delete(User $user, Customer $customer)
    {
        return $user->id === $customer->owner_id || $user->hasRole('SystemWallet');
    }
}
