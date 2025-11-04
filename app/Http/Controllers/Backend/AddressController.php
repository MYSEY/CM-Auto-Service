<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AddressController extends Controller
{
    public function district(Request $request){
        $district = DB::table('tb_district')->where('province_code',$request->province)->get();
        return response()->json(['data'=>$district]);
    }
    public function commune(Request $request)
    {
        $communes = DB::table('tb_commune')->where('district_code',$request->district)->get();
        return response()->json(['data'=>$communes]);
    }
    public function village(Request $request)
    {
        $villages = DB::table('tb_village')->where('commune_code',$request->commune)->get();
        return response()->json(['data'=>$villages]);
    }
}
