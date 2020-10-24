<?php

namespace App\Http\Controllers;

use App\Checkin;
use App\Product;
use App\ProductDetail;
use App\Sale;
use App\Staff;
use App\StockDetail;
use App\Transaction;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrCodesController extends Controller
{

    public function makeAll()
    {
        $products = StockDetail::all();
        $dyn_table = '<table border="1" cellpadding="10" bgcolor="#ffe4c4">';
        $i = 0;
        foreach ($products as $product)
        {
            $code = $product['code'];
            $name = $product['name'];
            if ($i % 4 == 0) { // if $i is divisible by our target number (in this case "4")
                $dyn_table .= '<tr><td>' .QrCode::size(200)->generate($code). ' '. $product['description']. '</td>';
            } else {
                $dyn_table .= '<td>' .QrCode::size(200)->generate($code). ' '. $product['description']. '</td>';
            }
            $i++;
        }
       return $dyn_table .= '</tr></table>';
    }

    public function createProduct(Request $request)
    {
        return Product::create($request->all());
    }


    public function recordSales(Request $request)
    {
        $result = Sale::create($request->all());
        $transaction = Transaction::create([
            'code'=>$request->code,
            'product_name'=>$request->make,
            'transaction'=>'Sale',
            'price'=>$request->price,
            'quantity'=>$request->quantity,
            'date'=>$request->date,
        ]);
        if($result)
        {
            return response()->json([
                "success" => true,
                "message" => "you have successfully inserted the data",
            ]);
        }
    }


    public function createStaff(Request $request)
    {
        return Staff::create($request->all());
    }

    public function allStaff()
    {
        $staffs = Staff::all();
        $dyn_table = '<table border="0" cellpadding="10" bgcolor="#ffe4c4">';
        $i = 0;
        foreach ($staffs as $staff)
        {
            if ($i % 4 == 0) { // if $i is divisible by our target number (in this case "4")
                $dyn_table .= '<tr><td>' .QrCode::size(200)->generate($staff). '</td>';
            } else {
                $dyn_table .= '<td>' .QrCode::size(200)->generate($staff). '</td>';
            }
            $i++;
        }
        return $dyn_table .= '</tr></table>';
    }

    public function uploadScans(Request $request)
    {
        return Checkin::create([
            'id'  => $request->id,
            'owner' => $request->make,
            'id_number' => $request->model,
            'serial' => $request->price,
            'department' => $request->quantity,
            'color' => $request->color,
            'date' => $request->date,
            'time' => $request->stage,
        ]);
    }

    public function allScans()
    {
        return Staff::all();


    }
}
