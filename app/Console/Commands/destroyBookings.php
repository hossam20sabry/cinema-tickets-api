<?php

namespace App\Console\Commands;

use App\Models\Booking;
use Illuminate\Console\Command;

class destroyBookings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'destroyBookings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'destroy bookings that not confirmed yet every 5 minutes';  

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Booking::where('booking_status', '!=', 'confirmed')->where('created_at', '<', now()->subMinutes(2))->delete();
    }
}
