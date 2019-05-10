<?php
return [
    'sms' => [
        'default' => [
            'Aliyun' => 'SMS_165285030',
        ],
    ],
    'cache' => [
        'ttl' => 600,
    ],
    'limit' => 10,
    'adminLimit' => 10,
    'upload' => [
        'max' => 2048,
    ],
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
                    'meta' => ['title' => '后台用户', 'icon' => 'user'],
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
                    'meta' => ['title' => '角色管理', 'icon' => 'list'],
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
        [
            'id' => 4,
            'path' => '/category',
            'component' => 'Layout',
            'children' => [
                [
                    'path' => 'list',
                    'component' => 'category_list',
                    'name' => 'category',
                    'meta' => ['title' => '分类管理', 'icon' => 'tree'],
                ],
            ],
        ],
        [
            'id' => 5,
            'path' => '/doc',
            'component' => 'Layout',
            'redirect' => '/doc/index',
            'meta' => ['title' => '文档管理', 'icon' => 'list'],
            'children' => [
                [
                    'id' => 6,
                    'path' => 'index',
                    'component' => 'doc_index',
                    'name' => 'doc_index',
                    'meta' => ['title' => '文档列表', 'icon' => 'list'],
                ],
                [
                    'id' => 7,
                    'path' => 'review',
                    'component' => 'doc_review',
                    'name' => 'doc_review',
                    'meta' => ['title' => '审核列表', 'icon' => 'list'],
                ],
            ],
        ],
        [
            'id' => 9,
            'path' => '/comment',
            'component' => 'Layout',
            'children' => [
                [
                    'path' => 'list',
                    'component' => 'comment_list',
                    'name' => 'comment',
                    'meta' => ['title' => '评论管理', 'icon' => 'wechat'],
                ],
            ],
        ],
    ],
];
