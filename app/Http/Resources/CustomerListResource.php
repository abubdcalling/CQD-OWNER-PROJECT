<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerListResource extends JsonResource
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
            'phone' => $this->phone,
            'email' => $this->email,
            'street' => $this->street,
            'city' => $this->city,
            'region' => $this->region,
            'zip_code' => $this->zip_code,
            'country' => $this->country,
            'address' => $this->address,
            'package_name' => $this->package?->type,
            'date' => $this->created_at->format('d/m/y'),
        ];
    }
}
