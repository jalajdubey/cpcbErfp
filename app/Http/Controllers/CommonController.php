<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\LgdStateDistricts;
class CommonController extends Controller
{
    // this controler is created by jalaj on 7-10-2025 for using common things available everywhere
   public function getDistrictsByState(Request $request)
    {
        $stateCode = $request->get('state_code');

        if (!$stateCode) {
            return response()->json([]);
        }

        $districts = LgdStateDistricts::where('state_code', $stateCode)
            ->select('id', 'district_name')
            ->orderBy('district_name')
            ->get();

        return response()->json($districts);
    }
}
