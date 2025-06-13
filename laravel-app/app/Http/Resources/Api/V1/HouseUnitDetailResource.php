<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class HouseUnitDetailResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => (int) $this->id,
            'name' => $this->house_unit_name,
            'imageUrl' => $this->house_unit_image
                ? asset(Storage::url($this->house_unit_image))
                : null,
            'summary' => strip_tags($this->houseType?->summary),
            'price' => (int) $this->houseType?->price,
            'typeName' => $this->houseType?->house_type_name,
            'status' => $this->status,

            'block' => [
                'id' => $this->blockHouseUnit?->id,
                'name' => $this->blockHouseUnit?->block_name,
                'latitude' => (float) $this->blockHouseUnit?->latitude,
                'longitude' => (float) $this->blockHouseUnit?->longitude,
            ],

            'facilities' => $this->houseType->facilities->map(fn ($facility) => [
                'id' => $facility->id,
                'imageUrl' => asset(Storage::url($facility->facility_image)),
                'name' => $facility->facility_name,
                'description' => $facility->description,
            ]),

            'marketing' => [
                'id' => $this->marketing?->id,
                'name' => $this->marketing?->name,
                'photoUrl' => $this->marketing?->photo
                    ? asset(Storage::url($this->marketing->photo))
                    : null,
                'phone' => $this->marketing?->phone,
                'email' => $this->marketing?->email,
            ],

            'galleries' => collect($this->houseUnitGalleries)->map(fn ($gallery) => [
                'id' => $gallery->id,
                'imageUrl' => asset(Storage::url($gallery->house_unit_gallery_image)),
                'name' => $gallery->house_unit_gallery_name,
                'description' => strip_tags($gallery->description),
            ]),
        ];
    }
}
