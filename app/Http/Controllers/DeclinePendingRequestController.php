<?php

namespace App\Http\Controllers;

use App\Enums\Messages;
use App\Models\Approval;
use App\Service\ApprovalService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeclinePendingRequestController extends Controller
{

    public function __invoke(Approval $approval): JsonResponse
    {
        $this->authorize('update', $approval);
        DB::transaction(function () use ($approval) {
            $approval->decline();
            $approval->delete();
        });
        return $this->respondSuccess([], Messages::REQ_DECLINED);
    }
}
