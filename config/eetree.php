<?php
return [
    'limit' => 10,
    'menus' => [
        [
            'id' => 1,
            'path' => '/adminuser',
            'component' => 'Layout',
            'children' => [
                'path' => 'index',
                'component' => 'adminuser_index',
                'name' => 'adminuser',
                'meta' => ['title' => 'adminuser', 'icon' => 'lock'],
            ],
        ],
        [
            'id' => 2,
            'path' => '/permission',
            'component' => 'Layout',
            'children' => [
                'path' => 'index',
                'component' => 'permission_index',
                'name' => 'permission',
                'meta' => ['title' => 'permission', 'icon' => 'lock'],
            ],
        ],
    ],
];
