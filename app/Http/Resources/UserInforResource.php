<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserInforResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'address' => $this->address,
            'phone' => $this->phone,
            'profile'=>$this->profile,
            'user_id'=>$this->user_id
            // Add other fields from UserInfor model
        ];
    }
}
