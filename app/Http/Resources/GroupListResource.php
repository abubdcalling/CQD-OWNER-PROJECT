<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GroupListResource extends JsonResource
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
            'zip_code' => $this->zip_code,
            'members_limit' => $this->total_members,
            'total_members' =>  $this->members->count(),
            'package_name' => $this->package->type,
            'members' => MemberListResource::collection($this->members),
        ];
    }
}
