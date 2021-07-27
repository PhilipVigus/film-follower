<?php

return [
    'rss-url' => env('RSS_URL', 'https://www.traileraddict.com/rss'),
    'rss-items-per-request' => 20,
    'guest-email' => env('GUEST_EMAIL', 'guest@user.com'),
    'guest-password' => env('GUEST_PASSWORD', 'password'),
];
