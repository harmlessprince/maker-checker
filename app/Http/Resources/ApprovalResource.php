<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ApprovalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $model = class_basename($this->approvable_type);
        $modelResource =  'App\Http\Resources\\' . '' . $model . 'Resource';
        $resourceClassExist = class_exists($modelResource);
        return [
            'request_id' => $this->id,
            'request_type' => $this->operation,
            'model_id' => $this->approvable_id > 0 ? $this->approvable_id : null,
            'model' => $model,
            'initial_values' => $resourceClassExist ? new $modelResource((object)$this->before) : $this->before,
            'changed_values' => $resourceClassExist ?   new $modelResource((object)$this->after) : $this->after,
            'created_by' => $this->createdBy->full_name,
            'is_approved' => (bool) $this->is_approved,
            'status' => $this->status,
            'approved_by' => optional($this->approvedBy)->full_name,
            'approved_at' => optional($this->approved_at)->format('Y-m-d H:m:i'),
            'declined_by' => optional($this->approvedBy)->full_name,
            'declined_at' => optional($this->approved_at)->format('Y-m-d H:m:i'),
            'submitted_at' => optional($this->created_at)->format('Y-m-d H:m:i'),
        ];
    }
}
