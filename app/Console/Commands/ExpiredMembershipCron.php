<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\StoreModal;
use App\Models\StoreMemberShip;
use App\Models\StoreInvoice;
use App\User;

class ExpiredMembershipCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'expired-membership:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will move all invoice or membership or renewal.';

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
     * @return int
     */
    public function handle()
    {
        // \Log::info("Cron is working fine!");
        // https://www.itsolutionstuff.com/post/laravel-8-cron-job-task-scheduling-tutorialexample.html
        $store_memberships = StoreMemberShip::whereDate('expiry_date', '<', date('Y-m-d'))->get();
        $store_ids = $store_memberships->pluck('store_id');
        StoreModal::whereIn('id', $store_ids)->update(['status'=> '2']);
        User::whereIn('store_id', $store_ids)->update(['status'=> 'inactive']);
        foreach ($store_memberships as $store_membership) {
            $start_date = date("Y-m-01");
            $start_date = date('Y-m-01', strtotime("+1 months", strtotime($start_date)));

            $timeToReduce = $store_membership->invoice_terms - 1;
            $expiry_date = date('Y-m-t', strtotime("+" . $timeToReduce . " months", strtotime($start_date)));
            StoreMemberShip::whereDate('expiry_date', '<=', date('Y-m-d'))->update(['status' => 'inactive', 'expiry_date' => $expiry_date]);
            $invoice_amount = $store_membership->web_charges + $store_membership->app_charges + $store_membership->shop_charges;   
            $invoice = [];
            $invoice['invoice_type'] = 1;
            $invoice['store_id'] = $store_membership->store_id;
            $invoice['status'] = 0;
            $invoice['payment'] = $invoice_amount;
            $invoice['start_date'] =  $start_date;
            $invoice['expiry_date'] = $expiry_date;
            StoreInvoice::create($invoice);
        }
    }
    
}
