<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MemberListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'company_name' => $this->company_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'street' => $this->street,
            'city' => $this->city,
            'region' => $this->region,
            'zip_code' => $this->zip_code,
            'address' => $this->address,
            'country' => $this->country,
            'package_name' => $this->package?->type,
            'date' => $this->created_at->format('d/m/y'),
        ];
    }
}
