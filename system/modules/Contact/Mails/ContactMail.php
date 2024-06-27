<?php

namespace Modules\Contact\Mails;

use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;

class ContactMail extends Mailable
{
    public $name;
    public $email;
    public $title;
    public $content;
    public $phone;

    /**
     * Create a new message instance.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->name = $request->input('name');
        $this->email = $request->input('email');
        $this->phone = $request->input('phone');
        $this->title = $request->input('subject') ?: trans('contact::web.no_title_email');
        $this->content = nl2br(strip_tags($request->input('message')));
        $this->subject = trans('contact::web.subject_mail', [
            'name' => $this->name,
            'app' => get_option('site_name')
        ]);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('contact::contact')
            ->to(get_option('site_email'))
            ->replyTo($this->email );
    }
}
