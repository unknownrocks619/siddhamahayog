<?php

return [
    'pricings' => [
        [
            'slug' => 'one-day-access',
            'title' => 'One Day Access',
            'description' => 'Get Exclusive one day access to video.',
            'offer' => false,
            'offer_price' => [],
            'access' => 1,
            'pricing' => [
                'amount' => 150,
                'discount' => 0,
                'total' => 150,
                'currency' => 'NPR'
            ]
        ],
        [
            'slug' => 'seven-days-access',
            'title' => '7 Days Access',
            'description' => 'Get Exclusive one day access to video.',
            'offer' => false,
            'offer_price' => [],
            'access' => 1,
            'pricing' => [
                'amount' => 1000,
                'discount' => 0,
                'total' => 1000,
                'currency' => 'NPR'
            ]
        ],
        [
            'slug' => 'seven-days-access',
            'title' => '15 Days Access',
            'description' => 'Get Exclusive one day access to video.',
            'offer' => false,
            'offer_price' => [],
            'access' => 1,
            'pricing' => [
                'amount' => 1500,
                'discount' => 0,
                'total' => 1500,
                'currency' => 'NPR'
            ]
        ]
    ],
    'payment_method' => 'esewa, voucher-upload,stripe',
    'enable' => true
];
