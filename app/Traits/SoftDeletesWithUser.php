<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\SoftDeletes;

trait SoftDeletesWithUser
{
    use SoftDeletes;

    protected static function bootSoftDeletesWithUser()
    {
        static::deleting(function ($model) {
            // Get the ID of the user performing the deletion
            $userId = auth()->id();
            if ($userId) {
                // Set the deleted_by_id field
                $model->deleted_by_id = $userId;
                $model->saveQuietly(); // Use saveQuietly to avoid triggering events
            }
        });
    }
}
