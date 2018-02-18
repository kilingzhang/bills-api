<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BillController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $rules = [
            'name' => 'required|string',
            'amount' => 'required|int',
            'remark' => 'required|string',
            'customer_id' => 'required|int'
        ];

        $this->validate($request, $rules);

        $bill = new Bill;
        $bill->name = $request->input('name');
        $bill->amount = $request->input('amount');
        $bill->remark = $request->input('remark');
        $bill->customer_id = $request->input('customer_id');

        $bill->save();

        return $bill;
    }

    public function showCustomerBills(Request $request, $customerId)
    {
        $rules = [
            'page' => 'required|int',
            'limit' => 'required|int',
            'start' => 'required|date',
            'end' => 'date',
        ];
        $this->validate($request, $rules);


        $page = $request->input('page');
        $limit = $request->input('limit');
        $start = $request->input('start');
        $end = $request->input('end');


        $customer = Customer::findOrFail($customerId);


        $end = $end ?? $start;

        $count = DB::table('bills')
            ->where('deleted_at', null)
            ->whereDate('created_at', '>=' , $start)
            ->whereDate('created_at', '<=', $end)
            ->where('customer_id',$customerId)
            ->count();

        $bills = DB::table('bills')
            ->where('deleted_at', null)
            ->whereDate('created_at', '>=' , $start)
            ->whereDate('created_at', '<=', $end)
            ->where('customer_id',$customerId)
            ->offset(($page - 1) * $limit)
            ->limit($limit)
            ->get();
        return [
            'total'=>$count,
            'customer' => $customer,
            'bills' => $bills
        ];
    }

    public function showBills(Request $request)
    {
        $rules = [
            'page' => 'required|int',
            'limit' => 'required|int',
            'start' => 'required|date',
            'end' => 'date',
        ];
        $this->validate($request, $rules);


        $page = $request->input('page');
        $limit = $request->input('limit');
        $start = $request->input('start');
        $end = $request->input('end');

        $end = $end ?? $start;

        $count = DB::table('bills')
            ->where('deleted_at', null)
            ->whereDate('created_at', '>=' , $start)
            ->whereDate('created_at', '<=', $end)
            ->count();

        $bills = DB::table('bills')
            ->where('deleted_at', null)
            ->whereDate('created_at', '>=' , $start)
            ->whereDate('created_at', '<=', $end)
            ->offset(($page - 1) * $limit)
            ->limit($limit)
            ->get();
        return [
            'total'=>$count,
            'customer' => '',
            'bills' => $bills
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required|string',
            'amount' => 'required|int',
            'remark' => 'required|string',
        ];

        $this->validate($request, $rules);

        $bill = Bill::findOrFail($id);
        $bill->name = $request->input('name');
        $bill->amount = $request->input('amount');
        $bill->remark = $request->input('remark');

        $bill->save();

        return $bill;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        return Bill::destroy($id);
    }
}
