<?php

namespace App\Http\Controllers;

use App\Inspection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InspectionController extends Controller
{
    /**
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function insert(Request $request)
    {
       $inspection = Inspection::create(
        $request->all()
       );

       if($inspection)
       {
           return response()->json([
               "success" => true,
               "message" => "you have successfully inserted the data",
           ]);
       }

       return response()->json([
           "success" => false,
           "message" => "there was an error on inserting"
       ]);

    }
}
