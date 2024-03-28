<?php

return [
    /*
    |--------------------------------------------------------------------------
    | System admin mail
    |--------------------------------------------------------------------------
    |
    | Use for BCC mail
    |
    */

    'system_admin_mail' => stringToArray(env('SYSTEM_ADMIN_MAIL')),

    /*
    |--------------------------------------------------------------------------
    | Environment color
    |--------------------------------------------------------------------------
    |
    | Set color for different environments.
    | To use default css color, don't set this env variable (for Production).
    |
    */

    'env_color' => env('ENV_COLOR'),

    /*
    |--------------------------------------------------------------------------
    | Is schedule batch
    |--------------------------------------------------------------------------
    |
    | Set true to schedule batch.
    |
    */

    'batch_schedule' => env('BATCH_SCHEDULE'),

    /*
    |--------------------------------------------------------------------------
    | Is update batch to DB
    |--------------------------------------------------------------------------
    |
    | Set true to update disable_flg in BAT020.
    |
    */

    'batch_update' => env('BATCH_UPDATE'),

    /*
    |--------------------------------------------------------------------------
    | bat_mst
    |--------------------------------------------------------------------------
    |
    | Set time to check data from db
    |
    */
    'bat_mst_customer' => env('BAT_MST_CUSTOMER'),
    'bat_mst_holiday' => env('BAT_MST_HOLIDAY'),
    'bat_mst_item' => env('BAT_MST_ITEM'),
    'bat_mst_item_office' => env('BAT_MST_ITEM_OFFICE'),
    'bat_mst_item_detail' => env('BAT_MST_ITEM_DETAIL'),
    'bat_mst_price' => env('BAT_MST_PRICE'),
    'bat_mst_price_advance' => env('BAT_MST_PRICE_ADVANCE'),

    /*
    |--------------------------------------------------------------------------
    | Firebase Cloud Messaging server key
    |--------------------------------------------------------------------------
    |
    | Use for send push notification
    |
    */

    'fcm_server_key' => env('FCM_SERVER_KEY'),
];
