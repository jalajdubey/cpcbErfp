<?php

namespace App\Http\Controllers;

use App\Models\LgdStateDistricts;
use Illuminate\Http\Request;

class GeneralController extends Controller
{

    public function index() {}
    public function getDistrictsByState(Request $request)
    {

        $stateCode = $request->get('state_code');

        if (!$stateCode) {
            return response()->json([]);
        }

        $districts = LgdStateDistricts::where('state_code', $stateCode)
            ->select('id', 'district_name')
            ->distinct()
            ->orderBy('district_name')
            ->get();

        return response()->json($districts);
    }
    public function verifyCaptcha(Request $request)
    {
        if (!captcha_check($request->input('captcha'))) {
            return response()->json(['success' => false, 'message' => 'Invalid CAPTCHA']);
        }

        return response()->json(['success' => true]);
    }
}
