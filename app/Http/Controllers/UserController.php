<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class UserController extends BaseController
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


    public function login(Request $request)
    {
        $rules = [
            'username' => 'required|string',
            'password' => 'required|string',
        ];

        $this->validate($request, $rules);
        $username = $request->input('username');
        $password = $request->input('password');


        if ($username !== $password) {
            return response('Unauthorized', 401);
        }

        $key = 'login_token_' . $username;

        $token = Cache::get($key);

        if (empty($token)) {
            $token = md5('bills_login' . time());
            $expiresAt = Carbon::now()->addDay(1);
            Cache::put($key, $token, $expiresAt);
        }



        return Response([
            'code' => 0,
            'msg' => 'success',
            'data' => [
                'token' => $token,
            ]
        ]);
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
        $date = date('Y-m-d', time());

        $amount['count'] = DB::table('bills')
            ->where('deleted_at', null)
            ->whereDate('created_at', $date)
            ->pluck('amount')
            ->sum();



        $bills['count'] = DB::table('bills')
            ->where('deleted_at', null)
            ->whereDate('created_at', $date)
            ->pluck('id')
            ->count();

        $bills['data'] = DB::table('bills')
            ->where('deleted_at', null)
            ->whereDate('created_at', $date)
            ->pluck('id');

        $customers['count'] = DB::table('bills')
            ->where('deleted_at', null)
            ->whereDate('created_at', $date)
            ->groupBy('customer_id')
            ->pluck('customer_id')
            ->count();

        $customers['data'] = DB::table('bills')
            ->where('deleted_at', null)
            ->whereDate('created_at', $date)
            ->groupBy('customer_id')
            ->pluck('customer_id');


        $data = [
            'code' => 0,
            'amount' =>$amount,
            'customers' => $customers,
            'bills' => $bills,
        ];

        return $data;
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
        //
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
    }
}
