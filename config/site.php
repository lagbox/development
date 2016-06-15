<?php

return [
    'images' => [
        'storage' => [
            'disk' => 'local',
            'path' => 'public/images/media',
            'public_path' => 'images/media',

            'disks' => [
                'public' => [
                    'disk' => 'public',
                    'path' => 'images/media',
                    'public_path' => 'storage/images/media',
                ],
                'default' => [
                    'disk' => 'local',
                    'path' => 'public/images/media',
                    'public_path' => 'images/media',
                ],
            ],
            'default' => 'default',
        ],
    ],
];
