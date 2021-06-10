<?php

namespace App\Jobs;

use App\Mail\AuditMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class MailAudit implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $audit;

    /**
     * Create a new job instance.
     *
     * @param mixed $audit
     *
     * @return void
     */
    public function __construct($audit)
    {
        $this->audit = $audit;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $cc = Str::of(config('services.mail.cc'))->explode(';');

        $cc->push($this->audit->adviser->email);

        Mail::to($this->audit->creator->email)
            ->cc($cc->all())
            ->send(new AuditMail($this->audit));
    }
}
