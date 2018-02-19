<?php

namespace App\Console\Commands;

use App\Models\Bill;
use App\Models\Customer;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MoveSqlCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sql:move';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
//        //
//        $accounts = DB::table('account')
//            ->get();
//        foreach ($accounts as $account){
//            $bill = new Bill();
//            $bill->id = $account->id;
//            $bill->name = $account->name;
//            $bill->amount = $account->money;
//            $bill->created_at = $account->date;
//            $bill->customer_id = $account->shop_id;
//            $bill->remark = $account->remark;
//            $bill->save();
//        }

    }
}
