<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Approval extends Model
{
    use HasFactory, SoftDeletes;

    public $guarded = [];

    /**
     * Get the parent commentable model (post or video).
     */
    public function approvable()
    {
        return $this->morphTo();
    }
}
