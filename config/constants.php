<?php

return [
    'CASHIER_CURRENCY'                               => env('CASHIER_CURRENCY'),
    'STRIPE_KEY'                                     => env('STRIPE_PUBLISH_KEY'),
    'STRIPE_SECRET'                                  => env('STRIPE_SECRET_KEY'),

    'SITE_POST_IMAGE_DIMENSION'                    => '530xnull',
    'SITE_COLLECTION_IMAGE_DIMENSION'              => 'nullx210',
    'SITE_COVER_IMAGE_DIMENSION'                   => '1400xnull', //Exclusive Slider
    'SITE_PROFILE_IMAGE_DIMENSION'                 => '400xnull',
    'SITE_THUMBNAIL_IMAGE_DIMENSION'               => '100x100',
    'SITE_PHOTO_STORE_IMAGE_DIMENSION'             => '172x210',
    'SITE_WEBP_STORE_IMAGE_DIMENSION'              => '384x641',

    'STANDARD_IMAGE_DIMENSION' => '1920x800',  /* WxH */
    'DOUBLE_IMAGE_DIMENSION' => '3840x1600',     /* WxH */



    'SITE_ORIGINAL_IMAGE_UPLOAD_PATH'              => 'images/original/',

    'SITE_USER_IMAGE_UPLOAD_PATH'                  => 'images/original/user',
    'SITE_USER_IMAGE_THUMBNAIL_PATH'               => 'images/thumbnail/user',
    'SITE_USER_IMAGE_WEBP_PATH'                    => 'images/webp/user',

    'SITE_LOGO_IMAGE_UPLOAD_PATH'                  => 'images/original/logo/',
    'SITE_LOGO_IMAGE_THUMBNAIL_PATH'               => 'images/thumbnail/logo/',
    'SITE_LOGO_IMAGE_WEBP_PATH'                    => 'images/webp/logo/',

    'SITE_LOCATION_IMAGE_UPLOAD_PATH'                  => 'images/original/location/',
    'SITE_LOCATION_IMAGE_THUMBNAIL_PATH'               => 'images/thumbnail/location/',
    'SITE_LOCATION_IMAGE_WEBP_PATH'                    => 'images/webp/location/',

    'SITE_AADHAAR_IMAGE_UPLOAD_PATH'                  => 'images/original/aadhaar/',
    'SITE_AADHAAR_IMAGE_THUMBNAIL_PATH'               => 'images/thumbnail/aadhaar/',
    'SITE_AADHAAR_IMAGE_WEBP_PATH'                    => 'images/webp/aadhaar/',

    'SITE_BANNER_IMAGE_UPLOAD_PATH'                => 'images/original/banner/',
    'SITE_BANNER_IMAGE_THUMBNAIL_PATH'             => 'images/thumbnail/banner/',
    'SITE_BANNER_IMAGE_WEBP_PATH'                  => 'images/webp/banner/',

    'SITE_FOOD_IMAGE_UPLOAD_PATH'                => 'images/original/food/',
    'SITE_FOOD_IMAGE_THUMBNAIL_PATH'             => 'images/thumbnail/food/',
    'SITE_FOOD_IMAGE_WEBP_PATH'                  => 'images/webp/food/',

    'SITE_WORKOUT_IMAGE_UPLOAD_PATH'                => 'images/original/workout/',
    'SITE_REWARD_IMAGE_UPLOAD_PATH'                => 'images/reward/',
    'SITE_WORKOUT_IMAGE_THUMBNAIL_PATH'             => 'images/thumbnail/workout/',
    'SITE_WORKOUT_IMAGE_WEBP_PATH'                  => 'images/webp/workout/',
    

    'SITE_BRAND_IMAGE_UPLOAD_PATH'                => 'images/original/brand/',
    'SITE_BRAND_IMAGE_THUMBNAIL_PATH'             => 'images/thumbnail/brand/',
    'SITE_BRAND_IMAGE_WEBP_PATH'                  => 'images/webp/brand/',

    'SITE_BLOG_IMAGE_UPLOAD_PATH'                => 'images/original/blog/',
    'SITE_BLOG_IMAGE_THUMBNAIL_PATH'             => 'images/thumbnail/blog/',
    'SITE_BLOG_IMAGE_WEBP_PATH'                  => 'images/webp/blog/',

    /* 'SITE_LOGO_IMAGE_UPLOAD_PATH'                => 'images/original/logo/',
    'SITE_LOGO_IMAGE_THUMBNAIL_PATH'             => 'images/thumbnail/logo/',
    'SITE_LOGO_IMAGE_WEBP_PATH'                  => 'images/webp/logo/',
 */
    'SITE_CATEGORY_IMAGE_UPLOAD_PATH'              => 'images/original/category/',
    'SITE_CATEGORY_IMAGE_THUMBNAIL_PATH'           => 'images/thumbnail/category/',
    'SITE_CATEGORY_IMAGE_WEBP_PATH'                => 'images/webp/category/',

    'SITE_PRODUCT_IMAGE_UPLOAD_PATH'               => 'images/original/product/',
    'SITE_PRODUCT_IMAGE_THUMBNAIL_PATH'            => 'images/thumbnail/product/',
    'SITE_PRODUCT_IMAGE_WEBP_PATH'                 => 'images/webp/product/',

    'SITE_SELLER_DOCUMENT_UPLOAD_PATH'             => 'images/documents/seller/',
    'SITE_KYC_DOCUMENT_UPLOAD_PATH'                 => 'documents/kyc/',

    'SITE_AGENT_DOCUMENT_UPLOAD_PATH'              => 'images/documents/agent/',

    'SITE_CMS_IMAGE_UPLOAD_PATH'                   => 'images/cms/',

    'SITE_DOCUMENT_UPLOAD_PATH'                    => 'images/documents/',

    'SITE_WEBP_IMAGE_UPLOAD_PATH'                  => 'images/webp/',
    'SITE_POST_IMAGE_UPLOAD_PATH'                  => 'images/post/',
    'SITE_COLLECTION_IMAGE_UPLOAD_PATH'            => 'images/collection/',
    'SITE_COVER_IMAGE_UPLOAD_PATH'                 => 'images/cover/',
    'SITE_PROFILE_IMAGE_UPLOAD_PATH'               => 'images/profile/',
    'SITE_THUMBNAIL_IMAGE_UPLOAD_PATH'             => 'images/thumbnail/',
    'SITE_PHOTO_STORE_IMAGE_UPLOAD_PATH'           => 'images/photo-store/',

    'SITE_VIDEO_UPLOAD_PATH'                       => 'videos/',
    'SITE_VIDEO_TRAILER_UPLOAD_PATH'               => 'videos/trailer/',
    'SITE_VIDEO_TRAILER_CLIP_STARTING_TIME_IN_SEC' => 0,
    'SITE_VIDEO_TRAILER_CLIP_DURATION'             => 10,

    'SITE_FILE_STORAGE_DISK'                       => env('FILE_STORAGE_DISK', 'public'),


    //EMAIL
    'SITE_MAIL_FROM'                               => '',
    'SITE_REPLY_TO'                                => '',
    'SITE_MAIL_GREETINGS'                          => 'Regards,',
    'SITE_MAIL_GREETINGS_FROM'                     => '',
    'SITE_NAME'                                    => '',
    'SITE_URL_FOR_MAIL'                            => '',
];
