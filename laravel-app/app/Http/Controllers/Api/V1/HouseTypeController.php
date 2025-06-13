<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\HouseTypeDetailResource;
use App\Models\HouseType;

class HouseTypeController extends Controller
{
    public function show(HouseType $houseType)
    {
        $data = $houseType->load(['houseUnits.blockHouseUnit', 'houseTypeGalleries'])
            ->toResource(HouseTypeDetailResource::class);

        return response()
            ->json([
                'success' => true,
                'message' => 'Get house type by id',
                'data' => $data,
            ], 200);
    }
}
