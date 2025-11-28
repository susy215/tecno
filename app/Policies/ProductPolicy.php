<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Product;
use App\Models\ProductImage;

class ProductPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('Create')? true : false;
    }
    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Product $product): bool
    {
        return $user->hasPermissionTo('Update')? true : false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Product $product): bool
    {
        return $user->hasPermissionTo('Delete')? true : false;
    }

    public function deleteImage(User $user, ProductImage $productImage): bool
    {
        return $user->hasPermissionTo('Delete')? true : false;
    }

}
