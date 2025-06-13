<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\HouseUnitStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\HomeResource;
use App\Models\BlockHouseUnit;
use App\Models\HouseType;
use App\Models\HouseUnit;

class HomeController extends Controller
{
    public function index()
    {
        $blockHouseUnits = BlockHouseUnit::get(['id', 'block_name']);

        $houseTypes = HouseType::get(['id', 'house_type_image', 'house_type_name', 'price']);

        $houseUnits = HouseUnit::with(['blockHouseUnit', 'houseType'])
            ->where('status', HouseUnitStatusEnum::TERSEDIA)
            ->get();

        return response()
            ->json([
                'success' => true,
                'message' => 'Get resource home',
                'data' => new HomeResource([
                    'blockHouseUnits' => $blockHouseUnits,
                    'houseTypes' => $houseTypes,
                    'houseUnits' => $houseUnits,
                ]),
            ], 200);
    }
}
