<?php

namespace App\Console\Commands;

use App\Events\OrderChange;
use App\Models\Order;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class AutoCompleteOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:auto-complete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $orders = Order::where('status', 'delivered')
            ->where('updated_at', '<=', now()->subMinutes(1)) // 👉 đổi về subDays(2) khi chạy thật
            ->get();

        foreach ($orders as $order) {
            $order->status = 'completed';
            $order->save();
            event(new OrderChange($order->id));

            $this->info("Đơn hàng #{$order->id} đã hoàn thành tự động");
            Log::info("Đơn hàng #{$order->id} đã được hoàn thành sau 2 ngày.");
        }

        return Command::SUCCESS;
    }
}
