<?php

namespace App\Models;

use App\Enums\ApprovalStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Approval extends Model
{
    use HasFactory, SoftDeletes;

    public $guarded = [];

    protected $casts = ['before' => 'array', 'after' => 'array'];

    /**
     * Get the parent commentable model (post or video).
     */
    public function approvable()
    {
        return $this->morphTo();
    }

    public  function createdBy (){
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopePendingRequests(Builder $builder){
       return $builder
           ->where('is_approved', false)
           ->where('status', ApprovalStatus::PENDING)
           ->where('created_by', '<>', auth('sanctum')->id());
    }

    public function decline(){
        $this->status = ApprovalStatus::DECLINED;
        $this->declined_at = now();
        $this->declined_by = auth('sanctum')->id();
        $this->save();
    }
    public function approve(){
        $this->status = ApprovalStatus::APPROVED;
        $this->is_approved = 1;
        $this->approved_at = now();
        $this->approved_by = auth('sanctum')->id();
        $this->save();
    }
}
