<?php

namespace App\Http\Controllers;

use App\Enums\Messages;
use App\Models\Approval;
use App\Service\ApprovalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApprovePendingRequestController extends Controller
{
    public function __invoke(Approval  $approval, ApprovalService  $approvalService)
    {
        $this->authorize('update', $approval);
        DB::transaction(function () use ($approval, $approvalService){
            $approvalService->processRequest($approval);
            $approval->approve();
        });

        return $this->respondSuccess([], Messages::REQ_APPROVED);
    }
}
