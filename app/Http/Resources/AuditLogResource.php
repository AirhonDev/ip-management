<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AuditLogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'user' => $this->user,
            'ip_address' => $this->ip_address,
            'method' => $this->method,
            'request_path' => $this->request_path,
            'payload' => $this->payload,
            'action_time' => $this->action_time,
        ];
    }
}
