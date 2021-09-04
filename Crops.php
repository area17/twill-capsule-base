<?php

namespace App\Twill\Capsules\Base;

class Crops
{
    // Modules

    const HOMEPAGE = [
        'homepage-cover' => self::LANDSCAPE + self::MOBILE + self::SQUARE,

        'homepage-slideshow' => self::ORIGINAL,
    ];

    const COUNTRY = [
        'country-cover' => self::LANDSCAPE,
    ];

    const CITY = [
        'city-cover' => self::LANDSCAPE,
    ];

    // Block editor

    const BLOCK_EDITOR = [
        'block-editor' => self::LANDSCAPE + self::MOBILE + self::SQUARE + self::ORIGINAL,
    ];

    // Crops

    const ORIGINAL = [
        'original' => [
            [
                'name' => 'original',
                'ratio' => null,
            ],
        ],
    ];

    const LANDSCAPE = [
        'landscape' => [
            [
                'name' => 'landscape',
                'ratio' => 16 / 9,
            ],
        ],
    ];

    const MOBILE = [
        'mobile' => [
            [
                'name' => 'mobile',
                'ratio' => 3 / 2,
            ],
        ],
    ];

    const SQUARE = [
        'square' => [
            [
                'name' => 'square',
                'ratio' => 1,
            ],
        ],
    ];
}
