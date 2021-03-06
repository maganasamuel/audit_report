<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
     */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'company' => [
        'web' => env('COMPANY_WEB', 'www.eliteinsure.co.nz'),
        'url' => env('COMPANY_URL', 'https://eliteinsure.co.nz'),
    ],

    'training' => [
        'web' => env('TRAINING_WEB'),
        'url' => env('TRAINING_URL'),
    ],

    'not_user_types' => [1, 3],

    'user_types' => [1, 7, 8],

    'lead_source' => ['Telemarketer', 'BDM', 'Self-Generated'],

    'audit' => [
        'questions' => [
            'with_policy' => [
                'type' => 'boolean',
                'text' => '1. I understand you recently took out a policy with (insurance company) from one of our advisers, is that correct?',
            ],
            'confirm_adviser' => [
                'type' => 'boolean',
                'text' => '2. Was the adviser by him / herself?',
            ],
            'adviser_scale' => [
                'type' => 'select',
                'text' => "3. How would you describe the adviser's standard of service on a scale of 1-10? (10 as the highest)",
                'values' => [
                    ['value' => 1, 'label' => 1],
                    ['value' => 2, 'label' => 2],
                    ['value' => 3, 'label' => 3],
                    ['value' => 4, 'label' => 4],
                    ['value' => 5, 'label' => 5],
                    ['value' => 6, 'label' => 6],
                    ['value' => 7, 'label' => 7],
                    ['value' => 8, 'label' => 8],
                    ['value' => 9, 'label' => 9],
                    ['value' => 10, 'label' => 10],
                ],
            ],
            'medical_agreement' => [
                'type' => 'select',
                'text' => '4. As you are aware, non disclosure can lead to non payment of claim. To make sure the correct underwriting takes place, we have noted your current pre-existing medical conditions are ____________________________. Is there anything else apart from this not stated?',
                'values' => [
                    ['value' => 'yes', 'label' => 'Yes'],
                    ['value' => 'no', 'label' => 'No'],
                    ['value' => 'not sure', 'label' => 'Not Sure'],
                ],
            ],
            'medical_conditions' => [
                'type' => 'text',
                'text' => '',
            ],
            'bank_account_agreement' => [
                'type' => 'boolean',
                'text' => '5. We have received authority for all future payments to be direct debited from your bank account? Is this correct?',
            ],
            'replace_policy' => [
                'type' => 'boolean',
                'text' => '6. Did you take this policy to replace any other policy?',
            ],
            'replacement_is_discussed' => [
                'type' => 'select',
                'text' => 'Were the risks of replacing this insurance policy explained to you?',
                'values' => [
                    ['value' => 'yes', 'label' => 'Yes'],
                    ['value' => 'no', 'label' => 'No'],
                    ['value' => 'n/a', 'label' => 'Not Applicable'],
                ],
            ],
            'confirm_occupation' => [
                'type' => 'boolean',
                'text' => '7. We have your occupation recorded as ________________. Is that correct?',
            ],
            'occupation' => [
                'type' => 'text',
                'text' => '',
            ],
            'policy_understanding' => [
                'type' => 'text',
                'text' => '8. What is your understanding of the benefits of the policy?',
            ],
            'received_copy' => [
                'type' => 'boolean',
                'text' => '9. It specified in the authority to proceed that a copy of the disclosure statement was sent to you along with your insurance planner and plan to the email address example@abc.co.nz. Did you receive these?',
            ],
            'further_comments' => [
                'type' => 'text-optional',
                'text' => '10. Do you have any further comments?',
            ],
            'interviewer_completion' => [
                'type' => 'text',
                'text' => 'FOR INTERVIEWER TO COMPLETE',
                'class' => 'font-weight-bold',
                'pdf_class' => 'bg-info font-bold p-2',
            ],
            'is_action_taken' => [
                'type' => 'boolean',
                'text' => 'Remedial Action Taken Or Proposal:',
            ],
            'notes' => [
                'type' => 'text-optional',
                'text' => 'Notes:',
            ],
        ],
    ],

    'survey' => [
        'questions' => [
            'cancellation_discussed' => [
                'type' => 'boolean',
                'text' => 'Have you had a chance to discuss this cancellation with your Adviser?',
            ],
            'adviser' => [
                'type' => 'text',
                'text' => 'Who is your Adviser?',
            ],
            'policy_replaced' => [
                'type' => 'boolean',
                'text' => 'Are you replacing your Partners Life Policy with one at another Provider?',
            ],
            'policy_explained' => [
                'type' => 'boolean',
                'text' => 'Did your Adviser explain the differences between your Partners Life Policy and your new replacement insurance Policy?',
            ],
            'risk_explained' => [
                'type' => 'boolean',
                'text' => 'Did your Adviser explain the risk of Non-Disclosure or Misstatement to you?',
            ],
            'benefits_discussed' => [
                'type' => 'boolean',
                'text' => 'Did your Adviser discuss both the benefits you forfeit and any risks you might be exposed to in cancelling your cover from us?',
            ],
            'cancellation_reason' => [
                'type' => 'text',
                'text' => 'Why are you cancelling your Policy with us?',
            ],
            'insurer' => [
                'type' => 'text',
                'text' => 'Who is your new insurer?',
            ],
            'improvement' => [
                'type' => 'text',
                'text' => 'What could we do to improve?',
            ],
        ],
    ],

    'mail' => [
        'cc' => env(
            'MAIL_CC',
            implode(';', [
                'admin@eliteinsure.co.nz',
                'gurjeet@eliteinsure.co.nz',
            ])
        ),
        'domain' => env('MAIL_DOMAIN'),
    ],

];
