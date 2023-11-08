<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LoggedInUser extends JsonResource
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
            'id' => $this->id,
            'full_name' => $this->full_name ?? '',
            'avatar' => $this->avatar ?? '',
            'email' => $this->email ?? '',
            'phone_number' => $this->phone_number ?? '',
            'profile_completed' => $this->profile_completed ? 1 : 0,
            'zip_code' => $this->zip_code ?? '',
            'state' => $this->state ?? '',
            'address' => $this->address ?? '',
            'latitude' => $this->latitude ?? '',
            'longitude' => $this->longitude ?? '',
            'role' => $this->role ?? '',
            'email_verified_at' => $this->email_verified_at ?? '',
            'is_social' => $this->is_social ? 1 : 0,
            'notificaiton_toggle' => $this->notification_toggle?1:0,

        ];
    }
}
