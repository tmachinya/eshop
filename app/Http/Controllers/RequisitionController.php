<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Department;
use App\Requisition;
use App\Stock;
use App\StockDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RequisitionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Requisition[]|\Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        $requisition =  Requisition::where('status','pending')->get();
        $requisition->makeHidden(['created_at','updated_at']);
        return $requisition;

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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $array = $request->all();
        $name = StockDetail::where('code', $request->code)->first();
        $array['name'] = $name['name'];
        Requisition::create($array);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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
        $requisition = Requisition::find($id);
        $value = $requisition->update($request->all());
        $code = $request->code;
        $date = $request->date;
        $quantity = $request->quantity;
        if($request->status =='approved'){
            $p_descrs = StockDetail::where('code',$code)->get();
            foreach ($p_descrs as $p_descr){
                $descr = $p_descr->description;
                $name = $p_descr->name;
                $combined = $name.' '.$descr;
            }
            Stock::create([
                'code'=>$code,
                'name'=>$name,
                'description'=>$descr,
                'transaction_date'=>$date,
                'quantity'=>-$quantity,
                'transaction' => 'despatch',
                'by' => 'Despatched name'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $requisition = Requisition::find($id);
        $requisition->delete();
    }

    public function departments()
    {
        return Department::all();
    }

    public function allbranches()
    {
        return Branch::all();
    }

    public function sectionCost(Request $request)
    {
        $datas = Stock::selectRaw('code as kodi,max(price) as price')
            ->groupby('kodi');
       return $joins = DB::table('requisitions')
           ->where([['department',$request->department],
                   ['name',$request->category],
                   ['status','dispatched']
               ])
           ->whereBetween('date', [$request->start,$request->end])
           ->joinSub($datas, 'datas', function($join){
                $join->on('requisitions.code', '=', 'datas.kodi');
            })->get();
    }

    public function awaiting(Request $request){
        $data = $request->all();
        foreach ($data as $dats){
         $req =   Requisition::where(['req'=> $dats['req']])
             ->where('status','pending')
             ->get();
         foreach ($req as $reqs)
         {
             $reqs->update(['status'=> 'awaiting']);
         }

        }
    }

    public function waitingApproval()
    {
        return $datas = Requisition::selectRaw('req,count(req) as count')
            ->where('status','awaiting')
            ->groupby('req')
            ->get();
    }

    public function detailsAwaiting(Request $request){
        return Requisition::where('req', $request->req)->get();
    }

    public function hodApprovals(Request $request)
    {
        $data = $request->all();
        foreach ($data as $datas)
        {
            $req =   Requisition::where(['req'=> $datas['req']])
                ->where('status','awaiting')
                ->get();
            foreach ($req as $reqs)
            {
                $reqs ->update(['status'=> 'approved']);
            }

        }

    }

    public function waitingWarehouse()
    {
        return $datas = Requisition::selectRaw('req,count(req) as count')
            ->where('status','approved')
            ->groupby('req')
            ->get();
    }

    public function warehouseApproving(Request $request){
        $data = $request->all();
        foreach ($data as $datas)
        {
            $req =   Requisition::where(['req'=> $datas['req']])
                ->where('status','approved')
                ->get();
            foreach ($req as $reqs)
            {
                $quantity = $reqs['quantity'];
                $date = $reqs['date'];
                $reqs ->update(['status'=> 'dispatched']);
                    $p_descrs = StockDetail::where('code',$reqs['code'])->get();
                    foreach ($p_descrs as $p_descr){
                        $descr = $p_descr->description;
                        $name = $p_descr->name;
                        $code= $p_descr->code;
                        $combined = $name.' '.$descr.'';
                    }
                    Stock::create([
                        'code'=>$code,
                        'name'=>$name,
                        'description'=>$descr,
                        'transaction_date'=>$date,
                        'quantity'=>-$quantity,
                        'transaction' => 'despatch',
                        'by' => 'Warehouse'
                    ]);
            }

        }
    }

    public function departReport(Request $request)
    {
        return Requisition::where(['department'=>$request->department])->get();
    }
}
