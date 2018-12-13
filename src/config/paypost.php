<?php
/**
 * Created by PhpStorm.
 * User: dosarkz
 * Date: 2018-12-13
 * Time: 12:36
 */

return [
    'test_mode' =>  env('PAY_POST_TEST_MODE', true),
    'stages' => [
        'test' => [
            'url' => 'https://testpay.post.kz',
            'token' => env('PAY_POST_TEST_TOKEN'),
            'key' => env('PAY_POST_TEST_KEY', 'DEMO'),
        ],
        'prod' => [
            'url' => 'https://pay.post.kz',
            'token' => env('PAY_POST_PROD_TOKEN'),
            'key' => env('PAY_POST_PROD_KEY'),
        ]
    ],
    'back_link' => 'your back url',
    'urls' => [
        'generateUrl' => '/api/v0/orders/payment/',
    ]
];
