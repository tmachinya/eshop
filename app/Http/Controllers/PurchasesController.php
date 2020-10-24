<?php

namespace App\Http\Controllers;

use App\NewPrices;
use App\ProductDetail;
use App\Purchase;
use App\Stock;
use App\StockDetail;
use App\Transaction;
use Illuminate\Http\Request;

class PurchasesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $array = array();
        $purchase = Purchase::all();
        foreach ($purchase as $p){
            $p->expiry_date = date('Y-m-d',strtotime($p->expiry_date));
            $p->date = date('Y-m-d',strtotime($p->date));
            array_push($array, $p);
         }
        return response()->json($array);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        NewPrices::create([
            'code'=>$request->code,
            'price'=>$request->price,
        ]);
        $code = $request->code;
        $quantity = $request->quantity;
        $date = $request->date;
        $p_descrs = StockDetail::where('code',$code)->get();
        foreach ($p_descrs as $p_descr){
            $code1 = $p_descr->code;
            $descr = $p_descr->description;
            $name = $p_descr->name;
            $combined = $name.' '.$descr;
        }

      $stock = Stock::create([
            'code'=>$code,
            'price' =>$request->price,
            'name'=>$name,
            'description'=>$descr,
            'transaction_date'=>$date,
            'quantity'=>$quantity,
            'transaction' => 'purchase',
            'by' => 'request name'
        ]);
        if($stock){
            return response()->json([
                'success'=>true,
                'message'=>'done'
            ]);
        }
        return response()->json([
            'success'=>false,
            'message'=>'not done'
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return void
     */
    public function show(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $purchase = Purchase::find($id);
        $purchase->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $purchase = Purchase::find($id);
        $purchase->delete();
    }

    public function transactions()
    {
        $datas = Stock::selectRaw('code,sum(quantity) as sum,sum(price) as price')
            ->groupby('code')
            ->get();
        foreach ($datas as $data){
            $code = $data['code'];
            $objects = StockDetail::where('code',$code)->get();
            foreach ($objects as $object){
                $totalCost = $data['sum']*$data['price'];
                $data_array [] = [
                    'code'=>$code,
                    'name' =>$object->name,
                    'quantity' => $data['sum'],
                    'cost' => $totalCost,
                    'description' => $object->description,
                ];
            }


        }
        return $data_array;
    }

}
