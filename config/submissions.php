<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Submission Categories Configuration
    |--------------------------------------------------------------------------
    |
    | Define submission requirements for each competition category.
    | Each requirement has: type, stage, label, description, and max_size (MB)
    |
    */

    'categories' => [
        /*
        |--------------------------------------------------------------------------
        | Paper & Poster Competition (PPC)
        |--------------------------------------------------------------------------
        */
        'poster_paper' => [
            'name' => 'Paper & Poster Competition',
            'short_name' => 'PPC',
            'requirements' => [
                [
                    'type' => 'abstract',
                    'stage' => 'preliminary',
                    'label' => 'Abstract',
                    'description' => 'Submit your abstract document for preliminary review.',
                    'max_size' => 10, // MB
                    'required' => true,
                ],
                [
                    'type' => 'full_paper',
                    'stage' => 'semifinal',
                    'label' => 'Full Paper',
                    'description' => 'Submit your complete research paper.',
                    'max_size' => 20,
                    'required' => true,
                ],
                [
                    'type' => 'poster',
                    'stage' => 'semifinal',
                    'label' => 'Poster',
                    'description' => 'Submit your research poster in PDF format.',
                    'max_size' => 15,
                    'required' => true,
                ],
                [
                    'type' => 'presentation_slides',
                    'stage' => 'final',
                    'label' => 'Presentation Slides',
                    'description' => 'Submit your presentation slides for the final round.',
                    'max_size' => 25,
                    'required' => true,
                ],
            ],
        ],

        /*
        |--------------------------------------------------------------------------
        | Well Stimulation Competition (WSC)
        |--------------------------------------------------------------------------
        */
        'well_stimulation' => [
            'name' => 'Well Stimulation Competition',
            'short_name' => 'WSC',
            'requirements' => [
                [
                    'type' => 'essay',
                    'stage' => 'preliminary',
                    'label' => 'Essay',
                    'description' => 'Submit your essay for the preliminary stage.',
                    'max_size' => 10,
                    'required' => true,
                ],
                [
                    'type' => 'final_case_report',
                    'stage' => 'semifinal',
                    'label' => 'Final Case Report',
                    'description' => 'Submit your final case report for the semifinal stage.',
                    'max_size' => 25,
                    'required' => true,
                ],
                [
                    'type' => 'turnitin_report',
                    'stage' => 'semifinal',
                    'label' => 'Turnitin Similarity Report',
                    'description' => 'Submit the Turnitin similarity report for your case report.',
                    'max_size' => 10,
                    'required' => true,
                ],
                [
                    'type' => 'presentation_slides',
                    'stage' => 'final',
                    'label' => 'Presentation Slides',
                    'description' => 'Submit your presentation slides for the final stage.',
                    'max_size' => 25,
                    'required' => true,
                ],
            ],
        ],

        /*
        |--------------------------------------------------------------------------
        | Geothermal Development Plan Competition (GDPC)
        |--------------------------------------------------------------------------
        */
        'geothermal' => [
            'name' => 'Geothermal Development Plan Competition',
            'short_name' => 'GDPC',
            'requirements' => [
                [
                    'type' => 'essay',
                    'stage' => 'preliminary',
                    'label' => 'Essay',
                    'description' => 'Submit your essay for the preliminary round.',
                    'max_size' => 10,
                    'required' => true,
                ],
                [
                    'type' => 'final_report',
                    'stage' => 'semifinal',
                    'label' => 'Final Report',
                    'description' => 'Submit your final report for the semifinal round.',
                    'max_size' => 25,
                    'required' => true,
                ],
                [
                    'type' => 'presentation_slides',
                    'stage' => 'final',
                    'label' => 'Presentation Slides',
                    'description' => 'Submit your presentation slides for the final round.',
                    'max_size' => 25,
                    'required' => true,
                ],
            ],
        ],

        /*
        |--------------------------------------------------------------------------
        | Business Case Competition (BCC)
        |--------------------------------------------------------------------------
        */
        'business_case' => [
            'name' => 'Business Case Competition',
            'short_name' => 'BCC',
            'requirements' => [
                [
                    'type' => 'essay',
                    'stage' => 'preliminary',
                    'label' => 'Essay',
                    'description' => 'Submit your essay for the preliminary round.',
                    'max_size' => 10,
                    'required' => true,
                ],
                [
                    'type' => 'full_paper',
                    'stage' => 'semifinal',
                    'label' => 'Full Paper',
                    'description' => 'Submit your full paper for the semifinal round.',
                    'max_size' => 25,
                    'required' => true,
                ],
                [
                    'type' => 'pitch_deck',
                    'stage' => 'final',
                    'label' => 'Pitch Deck',
                    'description' => 'Submit your pitch deck for the final round.',
                    'max_size' => 30,
                    'required' => true,
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Display Names for Submission Types
    |--------------------------------------------------------------------------
    */
    'type_display_names' => [
        'abstract' => 'Abstract',
        'full_paper' => 'Full Paper',
        'poster' => 'Poster',
        'presentation_slides' => 'Presentation Slides',
        'essay' => 'Essay',
        'final_case_report' => 'Final Case Report',
        'turnitin_report' => 'Turnitin Similarity Report',
        'final_report' => 'Final Report',
        'pitch_deck' => 'Pitch Deck',
    ],

    /*
    |--------------------------------------------------------------------------
    | Stage Display Names
    |--------------------------------------------------------------------------
    */
    'stage_display_names' => [
        'preliminary' => 'Preliminary Round',
        'semifinal' => 'Semifinal Round',
        'final' => 'Final Round',
        'general' => 'General',
    ],

    /*
    |--------------------------------------------------------------------------
    | Active Stages Configuration
    |--------------------------------------------------------------------------
    |
    | Control which competition stages are currently active and visible to participants.
    | To enable a stage, add it to the array. To disable it, remove it.
    | 
    | Available stages: 'preliminary', 'semifinal', 'final'
    | 
    | Example - Enable all stages:
    |   'active_stages' => ['preliminary', 'semifinal', 'final']
    | 
    | Example - Only preliminary:
    |   'active_stages' => ['preliminary']
    |
    */
    'active_stages' => [
        'preliminary', // Currently active
        'semifinal', // Semifinal Round active
        'final',     // Final Round active
    ],

    /*
    |--------------------------------------------------------------------------
    | Global Settings
    |--------------------------------------------------------------------------
    */
    'settings' => [
        'allowed_mime_types' => ['application/pdf'],
        'allowed_extensions' => ['pdf'],
        'default_max_size' => 10, // MB
        'storage_disk' => 'public',
        'storage_path' => 'submissions',
    ],
];
