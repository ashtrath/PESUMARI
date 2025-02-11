<?php

namespace App\Policies;

use App\Models\User;
use App\Models\StudyProgram;
use Illuminate\Auth\Access\HandlesAuthorization;

class StudyProgramPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_study::program');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, StudyProgram $studyProgram): bool
    {
        return $user->can('view_study::program');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_study::program');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, StudyProgram $studyProgram): bool
    {
        return $user->can('update_study::program');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, StudyProgram $studyProgram): bool
    {
        return $user->can('delete_study::program');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_study::program');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, StudyProgram $studyProgram): bool
    {
        return $user->can('force_delete_study::program');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_study::program');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, StudyProgram $studyProgram): bool
    {
        return $user->can('restore_study::program');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_study::program');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, StudyProgram $studyProgram): bool
    {
        return $user->can('replicate_study::program');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_study::program');
    }
}
