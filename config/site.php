<?php

return [
    'uploads' => [
        'images' => [
            'storage' => [
                'disk' => 'public',
                'path' => 'images/media',
            ],
            'path' => public_path('images/media'),
            'default' => 'path',
        ],
    ]
];
