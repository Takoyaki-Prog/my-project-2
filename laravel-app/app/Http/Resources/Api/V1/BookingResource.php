<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class BookingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => (int) $this->id,
            'imageUrl' => asset(Storage::url($this->houseUnit->house_unit_image)),
            'unitName' => $this->houseUnit->house_unit_name,
            'blockName' => $this->houseUnit->blockHouseUnit->block_name,
            'typeName' => $this->houseUnit->houseType->house_type_name,
            'price' => (int) $this->houseUnit->houseType->price,
            'cost' => $this->cost,
            'status' => $this->status,
            'paymentDeadline' => $this->payment_deadline,
            'marketingPhoto' => asset(Storage::url($this->houseUnit->marketing->photo)),
            'marketingName' => $this->houseUnit->marketing->name,
            'marketingEmail' => $this->houseUnit->marketing->email,
            'marketingPhone' => $this->houseUnit->marketing->phone,
        ];
    }
}
