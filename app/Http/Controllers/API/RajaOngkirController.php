<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\RajaOngkirService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RajaOngkirController extends Controller
{
    protected $rajaOngkirService;

    public function __construct(RajaOngkirService $rajaOngkirService)
    {
        $this->rajaOngkirService = $rajaOngkirService;
    }

    public function provinces()
    {
        $response = $this->rajaOngkirService->getProvinces();
        return response()->json($response);
    }

    public function cities(int $provinceId)
    {
        $response = $this->rajaOngkirService->getCities($provinceId);
        return response()->json($response);
    }

    public function cekOngkir(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'origin' => 'required|integer',
            'destination' => 'required|integer',
            'weight' => 'required|integer|min:1',
            'courier' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $response = $this->rajaOngkirService->getShippingCost(
            $request->origin,
            $request->destination,
            $request->weight,
            $request->courier
        );

        return response()->json($response);
    }
}
