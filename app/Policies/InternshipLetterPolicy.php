<?php

namespace App\Policies;

use App\Models\InternshipLetter;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class InternshipLetterPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_internship::letter');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, InternshipLetter $internshipLetter): bool
    {
        return $user->can('view_internship::letter');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_internship::letter');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, InternshipLetter $internshipLetter): bool
    {
        return $user->can('update_internship::letter');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, InternshipLetter $internshipLetter): bool
    {
        return $user->can('delete_internship::letter');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_internship::letter');
    }

    public function accept(User $user, InternshipLetter $internshipLetter): bool
    {
        return $user->can('accept_internship::letter');
    }

    public function reject(User $user, InternshipLetter $internshipLetter): bool
    {
        return $user->can('reject_internship::letter');
    }
}
