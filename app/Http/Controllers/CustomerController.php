<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends BaseController
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
            'name' => 'required|string|unique:customers,name',
            'tel' => 'required|string|max:15',
            'remark' => 'required|string'
        ];

        $this->validate($request, $rules);

        $customer = new Customer;
        $customer->name = $request->input('name');
        $customer->tel = $request->input('tel');
        $customer->remark = $request->input('remark');

        $customer->save();

        return $customer;
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = Customer::findOrFail($id);
        return $customer;
    }

    public function showCustomers(Request $request)
    {
        $rules = [
            'page' => 'required|int',
            'limit' => 'required|int'
        ];
        $this->validate($request,$rules);

        $page = $request->input('page');
        $limit = $request->input('limit');

        $count = DB::table('customers')
            ->where('deleted_at',null)
            ->count();

        $customers = DB::table('customers')
            ->where('deleted_at',null)
            ->offset(($page - 1) * $limit)
            ->limit($limit)
            ->get();
        return [
            'total' => $count,
            'customers'=>$customers,
        ];
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
            'name' => 'required|string|unique:customers,name',
            'tel' => 'required|string|max:15',
            'remark' => 'required|string'
        ];

        $this->validate($request, $rules);

        $customer = Customer::findOrFail($id);

        $customer->name = $request->input('name');
        $customer->tel = $request->input('tel');
        $customer->remark = $request->input('remark');

        $customer->save();

        return $customer;


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
        return Customer::destroy($id);
    }
}
