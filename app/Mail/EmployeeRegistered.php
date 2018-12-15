<?php

namespace App\Mail;

use App\Models\Shop;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmployeeRegistered extends Mailable
{
    use Queueable, SerializesModels;

    public $employee;
    public $shop;
    public $password;

    /**
     * Create a new message instance.
     *
     * @param User $employee
     * @param Shop $shop
     * @param $password
     */
    public function __construct(User $employee, Shop $shop, $password)
    {
        $this->employee = $employee;
        $this->shop = $shop;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('tester@parafrasa.com', 'Tester Cube')
                ->markdown('emails.employees.registered');
    }
}
