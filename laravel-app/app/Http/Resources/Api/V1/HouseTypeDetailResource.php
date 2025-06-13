<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class HouseTypeDetailResource extends JsonResource
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
            'imageUrl' => $this->house_type_image
                ? asset(Storage::url($this->house_type_image))
                : null,
            'name' => $this->house_type_name,
            'summary' => strip_tags($this->summary),
            'price' => (int) $this->price,

            'facilities' => $this->facilities->map(fn ($facility) => [
                'id' => $facility->id,
                'imageUrl' => asset(Storage::url($facility->facility_image)),
                'name' => $facility->facility_name,
                'description' => $facility->description,
            ]),

            'units' => $this->houseUnits->map(fn ($unit) => [
                'id' => (int) $unit->id,
                'imageUrl' => $unit->house_unit_image
                    ? asset(Storage::url($unit->house_unit_image))
                    : null,
                'name' => $unit->house_unit_name,

                'block' => [
                    'name' => $unit->blockHouseUnit?->block_name,
                ],
            ]),

            'galleries' => $this->houseTypeGalleries->map(fn ($gallery) => [
                'imageUrl' => $gallery->house_type_gallery_image ? asset(Storage::url($gallery->house_type_gallery_image)) : null,
                'name' => $gallery->house_type_gallery_name,
                'description' => strip_tags($gallery->description),
            ]),
        ];
    }
}
