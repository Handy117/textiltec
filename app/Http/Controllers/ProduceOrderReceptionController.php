<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ProduceOrder;
use App\Models\ProduceOrderReception;
use PDF;

class ProduceOrderReceptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        ini_set('post_max_size', '100M');
        ini_set('upload_max_filesize', '100M');
    }

    public function index(Request $request, $id)
    {
        config(['site.page' => 'reception_list']);
        $order = ProduceOrder::find($id);
        $data = $order->receptions()->orderBy('receive_date')->get();
        return view('reception.index', compact('data', 'order', 'id'));
    }

    public function create(Request $request){
        $request->validate([
            'receive_date'=>'required|string',
            'quantity'=>'required|numeric',
        ]);
        
        $item = new ProduceOrderReception();
        $item->receive_date = $request->get('receive_date').":00";
        $item->quantity = $request->get('quantity');
        $item->produce_order_id = $request->get('produce_order_id');
        $item->save();
        return back()->with('success', 'Added Successfully');
    }

    public function edit(Request $request){
        $request->validate([
            'date'=>'required',
        ]);
        $item = ProduceOrderReception::find($request->get('id'));
        $item->receive_date = $request->get('date').":00";
        $item->quantity = $request->get('quantity');
        $item->save();
        return back()->with('success', __('page.updated_successfully'));
    }


    public function delete($id){
        $item = ProduceOrderReception::find($id);
        $item->delete();
        return back()->with("success", __('page.deleted_successfully'));
    }
    
    public function report($id){
        $reception = ProduceOrderReception::find($id);
        $produce_order =$reception->produce_order;
        $pdf = PDF::loadView('reception.report', compact('reception'))->setPaper('B5', 'landscape');  
        return $pdf->download('reception_report_'.$produce_order->reference_no.'.pdf');
        // return view('reception.report', compact('reception'));
    }
}
