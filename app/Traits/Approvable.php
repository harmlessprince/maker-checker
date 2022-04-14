<?php

namespace App\Traits;

use App\Enums\ApprovalStatus;
use App\Enums\Operations;
use App\Events\ApprovalSubmittedEvent;
use App\Exceptions\ApprovalExistsException;
use App\Models\Approval;
use App\Observers\ApprovableObserver;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Exception;

trait Approvable
{

    /**
     * @var string
     */
    private string $operation;

    /**
     * boot the trait and register the observer
     */
    public static function bootApprovable()
    {
        static::observe(new ApprovableObserver());
    }

    public function getOperation(): string
    {
        return $this->operation;
    }

    public function setOperation(string $event)
    {
        $this->operation = $event;
        return $this;
    }

    /**
     * save approval model
     *
     * @throws Exception
     */
    public function storeApproval()
    {
        $generatedData = $this->generateApproveData();

        $check = $this->approvalExists($generatedData);
        if (!$check) {
           $approval = Approval::create($generatedData);
           ApprovalSubmittedEvent::dispatch($approval);
        } else {
            throw new ApprovalExistsException('An admin already submitted the request');
        }
    }

    public function approvalExists($generatedData)
    {
        return Approval::query()
            ->where('status', ApprovalStatus::PENDING)
            ->where('approvable_id', $generatedData['approvable_id'])
            ->where('approvable_type', $generatedData['approvable_type'])
            ->where('operation', $generatedData['operation'])
            ->where('before', json_encode($generatedData['before']))
            ->where('after', json_encode($generatedData['after']))
            ->exists();
    }

    /**
     * @throws \Exception
     */
    public function generateApproveData(): array
    {
        $approvable_id = $this->id ?: 0;
        $diff = $this->getDiff();
        return [
            'created_by' => $this->getApprovalCreator(),
            'approvable_id' => $approvable_id,
            'approvable_type' => $this->getMorphClass(),
            'operation' => $this->getOperation(),
            'before' => $diff['before'],
            'after' => $diff['after'],
            'is_approved' => 0,
        ];
    }


    private function getApprovalCreator()
    {
        return Auth::guard('sanctum')->check() ? auth('sanctum')->user()->getAuthIdentifier() : 0;
    }


    protected function getDiff(): array
    {

        $changed = $this->getDirty();
        $fresh = $this->fresh() ? $this->fresh()->toArray() : [];
        //compare to original attributes in the db
        $before = array_intersect_key($fresh, $changed);
        $after = $changed;
        return compact('before', 'after');
    }

    /**
     * check whether user is can approve a request
     *
     * @return bool
     */
    public static function canApproveRequest(): bool
    {
        return false;
    }
}
