<?php

namespace App\Service;

use App\Enums\ApprovalStatus;
use App\Enums\Operations;

class ApprovalService
{

    public function processRequest($approval)
    {
        if ($approval->operation === Operations::CREATE) {
            return $this->create($approval);
        }
        if ($approval->operation === Operations::UPDATE) {
            return $this->update($approval);
        }
        if ($approval->operation === Operations::DELETE) {
            return $this->delete($approval);
        }
        return null;
    }

    public function create($approval)
    {
        $data = $approval->after;
        $model = $approval->approvable_type;
        return $model::withoutEvents(function () use ($data, $model) {
            return  $model::create($data);
        });
    }

    public function update($data)
    {
        return $data->approvable()->lockForUpdate()->update($data->after);
    }

    public function delete($data)
    {
        return $data->approvable()->lockForUpdate()->delete();
    }

}
