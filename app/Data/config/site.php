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

        // largest to smallest order
        'sizes' => [
            'lg' => 600,
            'md' => 400,
            'sm' => 200,
            'xs' => 80,
        ],

        'format' => function ($filename, $extension, $size) {
            return "{$filename}__{$size}.{$extension}";
        },
    ],
];
