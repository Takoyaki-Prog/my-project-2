<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\HouseUnitDetailResource;
use App\Models\HouseUnit;

class HouseUnitController extends Controller
{
    public function show(HouseUnit $houseUnit)
    {
        $data = $houseUnit->load([
            'blockHouseUnit',
            'houseType',
            'marketing',
            'houseUnitGalleries',
        ])->toResource(HouseUnitDetailResource::class);

        return response()
            ->json([
                'success' => true,
                'message' => 'Get house unit by id',
                'data' => $data,
            ]);
    }
}
