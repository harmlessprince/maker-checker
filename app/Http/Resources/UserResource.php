<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $me = optional($this);
        return [
            'first_name' =>  $this->when($me->first_name, $me->first_name),
            'last_name' =>  $this->when($me->last_name, $me->last_name),
            'email' =>  $this->when($me->email, $me->email),
            'role' =>  $this->when($me->role, $me->role),
        ];
    }
}
