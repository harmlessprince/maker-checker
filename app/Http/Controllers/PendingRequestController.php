<?php

namespace App\Http\Controllers;

use App\Http\Resources\ApprovalResource;
use App\Models\Approval;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PendingRequestController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Approval::class);

        return $this->respondWithResourceCollection(ApprovalResource::collection(Approval::pendingRequests()->simplePaginate()), 'All pending requests retrieved successfully');
    }

    public function show(Approval $approval): JsonResponse
    {
        $this->authorize('view', $approval);
        return $this->respondWithResource(new ApprovalResource($approval), 'Pending requests retrieved successfully');
    }
}
