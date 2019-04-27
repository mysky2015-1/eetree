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
                    'meta' => ['title' => '后台用户', 'icon' => 'lock'],
                ],
            ],
        ],
        [
            'id' => 2,
            'path' => '/role',
            'component' => 'Layout',
            'children' => [
                [
                    'path' => 'list',
                    'component' => 'role_list',
                    'name' => 'role',
                    'meta' => ['title' => '角色管理', 'icon' => 'lock'],
                ],
            ],
        ],
        [
            'id' => 3,
            'path' => '/permission',
            'component' => 'Layout',
            'children' => [
                [
                    'path' => 'list',
                    'component' => 'permission_list',
                    'name' => 'permission',
                    'meta' => ['title' => '权限管理', 'icon' => 'lock'],
                ],
            ],
        ],
    ],
];
