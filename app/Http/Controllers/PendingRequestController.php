<?php

namespace App\Http\Controllers;

use App\Models\Approval;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PendingRequestController extends Controller
{
    public function index(): JsonResponse
    {
        $this->authorize('viewAny', Approval::class);
        return $this->respondSuccess(['data' => Approval::pendingRequests()->simplePaginate()], 'All pending requests retrieved successfully');
    }

    public function show(Approval $approval): JsonResponse
    {
        $this->authorize('view', $approval);
        return $this->respondSuccess(['data' =>  $approval], 'Pending requests retrieved successfully');
    }
}
