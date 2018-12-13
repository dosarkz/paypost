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
            'token' => env('PAY_POST_TEST_TOKEN', '5dec5abefbc058ea1daa2ae1fa682d0a2eb13357'),
            'key' => env('PAY_POST_TEST_KEY', 'DEMO'),
        ],
        'prod' => [
            'url' => 'https://pay.post.kz',
            'token' => env('PAY_POST_PROD_TOKEN'),
            'key' => env('PAY_POST_PROD_KEY'),
        ]
    ],
    'back_link' => 'https://allsai.kz/payment/back',
    'urls' => [
        'generateUrl' => '/api/v0/orders/payment/',
    ]
];