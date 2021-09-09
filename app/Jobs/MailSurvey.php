<?php

namespace App\Jobs;

use App\Mail\SurveyMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class MailSurvey implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $survey;

    /**
     * Create a new job instance.
     *
     * @param mixed $survey
     *
     * @return void
     */
    public function __construct($survey)
    {
        $this->survey = $survey;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $cc = Str::of(config('services.mail.cc'))->explode(';');

        $cc->push($this->survey->adviser->email_address);

        Mail::to($this->survey->creator->email_address)
            ->cc($cc->all())
            ->send(new SurveyMail($this->survey));
    }
}
