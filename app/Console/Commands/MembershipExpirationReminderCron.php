<?php
namespace App\Console\Commands;
use Illuminate\Support\Facades\Mail;
use Illuminate\Console\Command;
use App\Models\StoreMemberShip;
class MembershipExpirationReminderCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'membership-expiration-reminder:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will send notification just one week before of expiration of membership.';

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
        \Log::info("Weekly Update has been send successfully.");
        $date_before_expiration = date('Y-m-d', strtotime("-6 days", strtotime(date('Y-m-d'))));
        $store_membership = StoreMemberShip::with(['store'])->whereDate('expiry_date', '=', $date_before_expiration)->get();
        foreach ($store_membership as $a){
            Mail::raw("Your membership is going to be expired at:". date('Y-M-d', strtotime($a->expiry_date)) .", Please renew it asap.", function($message) use ($a){
                // $message->from('abc@gmail.com');
                $message->to($a->email);
                $message->subject('A Soft Reminder');
            });
        }
    }
}
