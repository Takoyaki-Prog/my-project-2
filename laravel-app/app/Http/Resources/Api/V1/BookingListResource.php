<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class BookingListResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => (int) $this->id,
            'cost' => (int) $this->cost,
            'paymentDeadline' => $this->payment_deadline,
            'status' => $this->status,
            'unitName' => $this->houseUnit?->house_unit_name,
            'imageUrl' => $this->houseUnit?->house_unit_image
                ? asset(Storage::url($this->houseUnit->house_unit_image))
                : null,
            'typeName' => $this->houseUnit?->houseType?->house_type_name,
            'price' => (int) $this->houseUnit?->houseType?->price,
            'blockName' => $this->houseUnit?->blockHouseUnit?->block_name,
        ];
    }
}
