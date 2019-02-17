<?php

namespace App\Mail;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class DailySellingReport extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $report;
    public $date;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $report)
    {
        $this->user = $user;
        $this->report = $report;
        $this->date = Carbon::now()->toDayDateTimeString();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.report.daily');
    }
}
