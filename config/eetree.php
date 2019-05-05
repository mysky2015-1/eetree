<?php
return [
    'sms' => [
        'default' => [
            'SendCloud' => 1,
        ],
    ],
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
            'path' => '/article',
            'component' => 'Layout',
            'redirect' => '/article/publish',
            'meta' => ['title' => '文章管理', 'icon' => 'list'],
            'children' => [
                [
                    'id' => 6,
                    'path' => 'publish',
                    'component' => 'article_publish',
                    'name' => 'article_publish',
                    'meta' => ['title' => '已发布', 'icon' => 'list'],
                ],
                [
                    'id' => 7,
                    'path' => 'review',
                    'component' => 'article_review',
                    'name' => 'article_review',
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
