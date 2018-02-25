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
            'start' => 'date',
            'end' => 'date',
        ];
        $this->validate($request, $rules);


        $page = $request->input('page');
        $limit = $request->input('limit');
        $start = $request->input('start');
        $end = $request->input('end');

        $dateDuring = date('Y-m', strtotime('-3 month')) . '-' . date('Y-m', strtotime('-1 month'));

        $customer = Customer::findOrFail($customerId);


        $start = $start ?? '2016-01-01';
        $end = $end ?? $start;



        $count = DB::table('bills')
            ->where('deleted_at', null)
            ->whereDate('created_at', '>=', $start)
            ->whereDate('created_at', '<=', $end)
            ->where('customer_id', $customerId)
            ->count();


        $amount = DB::table('bills')
            ->where('deleted_at', null)
            ->where('customer_id', $customerId)
            ->sum("amount");

        $bills = DB::table('bills')
            ->select('bills.id as id', 'bills.name as name', 'customers.name as customer_name', 'bills.remark as remark', 'amount', 'bills.created_at')
            ->leftJoin('customers', 'customers.id', '=', 'bills.customer_id')
            ->where('bills.deleted_at', null)
            ->whereDate('bills.created_at', '>=', $start)
            ->whereDate('bills.created_at', '<=', $end)
            ->where('bills.customer_id', $customerId)
            ->orderByRaw('bills_bills.created_at DESC')
            ->offset(($page - 1) * $limit)
            ->limit($limit)
            ->get();

        return [
            'date' => $dateDuring,
            'total' => $count,
            'amount'=>$amount,
            'customer' => $customer,
            'bills' => $bills
        ];
    }

    public function showBills(Request $request)
    {
        $rules = [
            'page' => 'required|int',
            'limit' => 'required|int',
            'start' => 'date',
            'end' => 'date',
        ];
        $this->validate($request, $rules);


        $page = $request->input('page');
        $limit = $request->input('limit');
        $start = $request->input('start');
        $end = $request->input('end');

        $dateDuring = date('Y-m', strtotime('-3 month')) . '-' . date('Y-m', strtotime('-1 month'));

        $start = $start ?? '2016-01-01';
        $end = $end ?? $start;


        $count = DB::table('bills')
            ->where('deleted_at', null)
            ->whereDate('created_at', '>=', $start)
            ->whereDate('created_at', '<=', $end)
            ->count();



        $bills = DB::table('bills')
            ->select('bills.id as id', 'bills.name as name', 'customers.name as customer_name', 'bills.remark as remark', 'amount', 'bills.created_at')
            ->leftJoin('customers', 'customers.id', '=', 'bills.customer_id')
            ->where('bills.deleted_at', null)
            ->whereDate('bills.created_at', '>=', $start)
            ->whereDate('bills.created_at', '<=', $end)
            ->orderByRaw('bills_bills.created_at DESC')
            ->offset(($page - 1) * $limit)
            ->limit($limit)
            ->get();
        return [
            'date' => $dateDuring,
            'total' => $count,
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroyThree(Request $request, $customerId)
    {
        //


        $beginDate = date('Y-m-01 00:00:00', strtotime(date("Y-m-d") . '-3 month'));
        $firstDate = date('Y-m-01 00:00:00', strtotime(date("Y-m-d") . '-1 month'));
        $endDate = date('Y-m-d 23:59:59', strtotime("$firstDate +1 month -1 day"));

        $bills = DB::table('bills')
            ->where('deleted_at', null)
            ->whereDate('created_at', '>=', $beginDate)
            ->whereDate('created_at', '<=', $endDate);
        if (!empty($customerId) && $customerId != 'undefined') {
            $bills->where('customer_id', $customerId);
        }
        $bills = $bills
            ->pluck('id');

        $bills_ids = json_decode(json_encode($bills), true);

        return Bill::destroy($bills_ids);

    }
}
