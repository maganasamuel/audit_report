<?php

namespace App\Http\Controllers;

use App\Models\Audit;
use App\Models\Client;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;

class PDFController extends Controller
{
    public function show(Client $client, Audit $audit)
    {
        $audit = $client->audits()->where('audit_id', $audit->id)->first();

        $answers = json_decode($audit->qa, true);
        $questions = [

            [
                'question' => 'I understand you recently took out a policy with (fidelity, partners, aia) from one of our advisers Is that correct?',
                'answer' => $answers['with_policy']
            ],
            [
                'question' => 'Was the adviser by him / herself?',
                'answer' => $answers['confirm_adviser']
            ],
            [

                'question' => "How would you describe the adviser's standard of service on a scale of 1-10? (10 is the highest)",
                'answer' => $answers['adviser_scale']
            ],
            [
                'question' => 'As you are aware, non disclosure can lead to non payment of claim. To make sure the correct underwriting takes place , we have noted your current pre-existing medical conditions are',
                'answer' => $answers['medical_conditions']
            ],
            [
                'question' => 'Is there anything else apart from this not stated?',
                'answer' => $answers['medical_agreement']
            ],
            [
                'question' => 'We have received authority for all future payments to be direct debited from your bank account? Is this correct?',
                'answer' => $answers['bank_account_agreement']
            ],
            [
                'question' => 'Is there anything else apart from this not stated?',
                'answer' => $answers['medical_agreement']
            ],
            [
                'question' => 'Is that correct? ',
                'answer' => $answers['confirm_occupation']
            ],
            [
                'question' => 'What is your understanding of the benefits of the policy?',
                'answer' => $answers['policy_understanding']
            ],
            [
                'question' => 'It specified in the authority to proceed that a copy of the disclosure statement was given to you and your insurance planner and or plan/copy of your LAT was e mailed to e mail address John@eliteinsure..co.nz . Did you received them?',
                'answer' => $answers['received_copy']
            ],
            [
                'question' => 'Do you have any further comments?',
                'answer' => isset($answers['further_comments']) ? $answers['further_comments'] : 'N/A'
            ],

            [
                'question' => 'If replacement, were the risks of replacing this insurance policy explained to you?',
                'answer' => $answers['replacement_is_discussed']
            ],
            [
                'question' => 'Do you have any further comments?',
                'answer' =>  $answers['is_action_taken']
            ]
        ];


        $pdf= PDF::loadView('pdfs.view-pdf', [

            'weekOf' => $audit->pivot->weekOf,
            'lead_source' => $audit->pivot->lead_source,
            'audit' => $audit,
            'client' => $client,
            'questions' => $questions
        ]);


        return $pdf->stream();
    }
}
