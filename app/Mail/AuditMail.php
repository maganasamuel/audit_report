<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use niklasravnsborg\LaravelPdf\Facades\Pdf;

class AuditMail extends Mailable
{
    use Queueable, SerializesModels;

    public $audit;

    public $policy_holder;

    public $policy_no;

    /**
     * Create a new message instance.
     *
     * @param mixed $audit
     *
     * @return void
     */
    public function __construct($audit)
    {
        $this->audit = $audit;

        $this->policy_holder = $this->audit->client->policy_holder;
        $this->policy_no = $this->audit->client->policy_no;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $pdf = Pdf::loadView('pdfs.audit', [
            'audit' => $this->audit,
        ]);

        return $this->markdown('emails.audit')
            ->subject('Audit Report')
            ->attachData($pdf->output(), 'audit-report.pdf');

    }
}
