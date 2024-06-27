<?php

namespace Modules\Customer\Mails;

use Illuminate\Bus\Queueable;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Customer\Models\Customer;

class CustomerMail extends Mailable
{
    use Queueable, SerializesModels;

    public $customer;

    /**
     * Create a new message instance.
     *
     * @param Customer $customer
     */
    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mailer = $this->view('customer::customer_mail')
            ->subject(trans('customer::language.subject_mail_register', ['url' => get_option('site_url')]))
            ->to($this->customer->email);
        return $mailer;
    }
}
