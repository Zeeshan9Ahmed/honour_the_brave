<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BusinessResource extends JsonResource
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
            'business_name' => $this->business_name,
            'business_avatar' => $this->business_avatar,
            'email' => $this->email,
            'address' => $this->address,
            'social_links' => json_decode($this->social_links),
            'category_id' => $this->category_id,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'reviews' => ReviewResource::collection($this->reviews)
        ];;
    }
}
