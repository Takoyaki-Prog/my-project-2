<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class HomeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'blockHouseUnits' => collect($this['blockHouseUnits'])->map(fn ($block) => [
                'id' => (int) $block->id,
                'name' => $block->block_name,
            ]),

            'houseTypes' => collect($this['houseTypes'])->map(fn ($type) => [
                'id' => (int) $type->id,
                'imageUrl' => $type->house_type_image
                    ? asset(Storage::url($type->house_type_image))
                    : null,
                'name' => $type->house_type_name,
                'price' => (int) $type->price,
            ]),

            'houseUnits' => collect($this['houseUnits'])->map(fn ($unit) => [
                'id' => (int) $unit->id,
                'imageUrl' => $unit->house_unit_image
                    ? asset(Storage::url($unit->house_unit_image))
                    : null,
                'name' => $unit->house_unit_name,

                'block' => [
                    'id' => (int) $unit->blockHouseUnit?->id,
                    'name' => $unit->blockHouseUnit?->block_name,
                ],

                'houseType' => [
                    'id' => (int) $unit->houseType?->id,
                    'name' => $unit->houseType?->house_type_name,
                    'price' => (int) $unit->houseType?->price,
                ],
            ]),
        ];
    }
}
