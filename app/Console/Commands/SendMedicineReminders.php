<?php

namespace App\Console\Commands;

use App\Mail\MedicineReminderNotification;
use App\Models\Medicine;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendMedicineReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'medicine:send-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminder emails for medicines 5 minutes before their scheduled time.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        // Get current time and add 5 minutes
        $now = Carbon::now();
        $timeToRemind = $now->addMinutes(5)->format('H:i');

        // Fetch medicines with the scheduled time
        $medicines = Medicine::whereJsonContains('times', $timeToRemind)->get();

        foreach ($medicines as $medicine) {
            // Send email to user
            Mail::to($medicine->user->email)->send(new MedicineReminderNotification($medicine->name));

            $this->info("Reminder email sent for {$medicine->name} at {$timeToRemind}");
        }
    }
}
