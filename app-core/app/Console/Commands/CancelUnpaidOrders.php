<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class CancelUnpaidOrders extends Command
{
    protected $signature = 'orders:cancel-unpaid';
    protected $description = 'Cancel unpaid orders that are approved for over 2 minutes.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Retrieve orders that are approved and older than 2 minutes
        $orders = Order::where('status', 'approved')
        ->where('created_at', '<=', Carbon::now()->subHours(48))
        ->get();

        foreach ($orders as $order) {
            // Cancel the order by updating its status
            $order->update(['status' => 'cancelled_by_system']);
            
             Session::flash('info', "Order ID {$order->id} has been cancelled due to non-payment.");
        }

        $this->info('Cancelled unpaid approved orders older than 2 minutes.');
    }
}


