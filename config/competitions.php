<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Competition Categories
    |--------------------------------------------------------------------------
    |
    | Define all competition categories with their configurations
    |
    */

    //bagian final guidbook nanti diupdate kalau udah ada, sesuai route yg ada

    'categories' => [
        'business_case' => [
            'name' => 'Business Case Competition',
            'short_name' => 'BCC',
            'color' => '#FBB137',
            'border_color' => '#FBB137',
            'guidebook' => 'guidebooks/business_case_guidebook.pdf',
            'final_guidebook' => 'guidebooks/final/business_case_final_guidebook.pdf',
            'final_payment_rules' => 'guidebooks/final/payment-rules/business_case_final_payment_rules.pdf',
            'timeline' => [
                ['date' => '2 January - 9 January 2026', 'event' => 'Early Bird Registration'],
                ['date' => '10 January - 31 January 2026', 'event' => 'Regular Registration'],
                ['date' => '6 February 2026', 'event' => 'Preliminary Case Release'],
                ['date' => '20 February 2026', 'event' => 'Preliminary Submission'],
                ['date' => '27 February 2026', 'event' => 'Semifinal Announcement'],
                ['date' => '28 February 2026', 'event' => 'Final Case Release'],
                ['date' => '30 March 2026', 'event' => 'Semifinal Submission'],
                ['date' => '14 April 2026', 'event' => 'Final Announcement'],
                ['date' => '21 April 2026', 'event' => 'Pitch Deck Submission'],
                ['date' => '25 April 2026', 'event' => 'Final Pitch Day'],
                ['date' => '26 April 2026', 'event' => 'Awarding Night'],
            ],
        ],

        'geothermal' => [
            'name' => 'Geothermal Development Plan Competition',
            'short_name' => 'GDPC',
            'color' => '#B22A2A',
            'border_color' => '#B22A2A',
            'guidebook' => 'guidebooks/geothermal_guidebook.pdf',
            'final_guidebook' => 'guidebooks/final/geothermal_final_guidebook.pdf',
            'final_payment_rules' => 'guidebooks/final/payment-rules/geothermal_final_payment_rules.pdf',
            'timeline' => [
                ['date' => '2 January - 9 January 2026', 'event' => 'Early Bird Registration'],
                ['date' => '10 January - 31 January 2026', 'event' => 'Regular Registration'],
                ['date' => '6 February 2026', 'event' => 'Preliminary Case Release'],
                ['date' => '20 February 2026', 'event' => 'Preliminary Submission'],
                ['date' => '27 February 2026', 'event' => 'Semifinal Announcement'],
                ['date' => '28 February 2026', 'event' => 'Final Case Release'],
                ['date' => '30 March 2026', 'event' => 'Semifinal Submission'],
                ['date' => '14 April 2026', 'event' => 'Final Announcement'],
                ['date' => '21 April 2026', 'event' => 'Pitch Deck Submission'],
                ['date' => '25 April 2026', 'event' => 'Final Pitch Day'],
                ['date' => '26 April 2026', 'event' => 'Awarding Night'],
            ],
        ],

        'poster_paper' => [
            'name' => 'Poster and Paper Competition',
            'short_name' => 'PPC',
            'color' => '#4683B5',
            'border_color' => '#4683B5',
            'guidebook' => 'guidebooks/poster_paper_guidebook.pdf',
            'final_guidebook' => 'guidebooks/final/poster_paper_final_guidebook.pdf',
            'final_payment_rules' => 'guidebooks/final/payment-rules/poster_paper_final_payment_rules.pdf',
            'timeline' => [
                ['date' => '2 January - 9 January 2026', 'event' => 'Early Bird Registration'],
                ['date' => '10 January - 31 January 2026', 'event' => 'Regular Registration'],
                ['date' => '6 February 2026', 'event' => 'Preliminary Case Release'],
                ['date' => '20 February 2026', 'event' => 'Preliminary Submission'],
                ['date' => '27 February 2026', 'event' => 'Semifinal Announcement'],
                ['date' => '28 February 2026', 'event' => 'Final Case Release'],
                ['date' => '30 March 2026', 'event' => 'Semifinal Submission'],
                ['date' => '14 April 2026', 'event' => 'Final Announcement'],
                ['date' => '21 April 2026', 'event' => 'Pitch Deck Submission'],
                ['date' => '25 April 2026', 'event' => 'Final Pitch Day'],
                ['date' => '26 April 2026', 'event' => 'Awarding Night'],
            ],
        ],

        'well_stimulation' => [
            'name' => 'Well Stimulation Competition',
            'short_name' => 'WSC',
            'color' => '#32477C',
            'border_color' => '#32477C',
            'guidebook' => 'guidebooks/well_stimulation_guidebook.pdf',
            'final_guidebook' => 'guidebooks/final/well_stimulation_final_guidebook.pdf',
            'final_payment_rules' => 'guidebooks/final/payment-rules/well_stimulation_final_payment_rules.pdf',
            'timeline' => [
                ['date' => '2 January - 9 January 2026', 'event' => 'Early Bird Registration'],
                ['date' => '10 January - 31 January 2026', 'event' => 'Regular Registration'],
                ['date' => '6 February 2026', 'event' => 'Preliminary Case Release'],
                ['date' => '20 February 2026', 'event' => 'Preliminary Submission'],
                ['date' => '27 February 2026', 'event' => 'Semifinal Announcement'],
                ['date' => '28 February 2026', 'event' => 'Final Case Release'],
                ['date' => '30 March 2026', 'event' => 'Semifinal Submission'],
                ['date' => '14 April 2026', 'event' => 'Final Announcement'],
                ['date' => '21 April 2026', 'event' => 'Pitch Deck Submission'],
                ['date' => '25 April 2026', 'event' => 'Final Pitch Day'],
                ['date' => '26 April 2026', 'event' => 'Awarding Night'],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Payment Information
    |--------------------------------------------------------------------------
    */
    'payment' => [
        'bank_name' => 'SEABANK',
        'account_number' => '123456789',
        'account_holder' => 'AN FITRI',
        // fallback lama (opsional) jika per-kategori belum diisi
        'final_payment_rules_file' => 'guidebooks/final-payment-rules.pdf',
        'accepted_file_types' => ['png', 'jpeg', 'jpg', 'pdf'],
    ],
];
