<?php
return [
    'limit' => 10,
    'menus' => [
        [
            'id' => 1,
            'path' => '/adminuser',
            'component' => 'Layout',
            'children' => [
                [
                    'path' => 'list',
                    'component' => 'adminuser_list',
                    'name' => 'adminuser',
                    'meta' => ['title' => 'adminuser', 'icon' => 'lock'],
                ],
            ],
        ],
        [
            'id' => 2,
            'path' => '/permission',
            'component' => 'Layout',
            'children' => [
                [
                    'path' => 'list',
                    'component' => 'permission_list',
                    'name' => 'permission',
                    'meta' => ['title' => 'permission', 'icon' => 'lock'],
                ],
            ],
        ],
    ],
];
