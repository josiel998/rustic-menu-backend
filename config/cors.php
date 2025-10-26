<?php

use Illuminate\Http\Response;

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' => ['api/*'], // Restringe o CORS apenas para rotas /api

    'allowed_methods' => ['*'],

    'allowed_origins' => [env('FRONTEND_URL', 'http://localhost:8081')], // JÁ MODIFICADO PARA VOCÊ

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true, // JÁ MODIFICADO PARA VOCÊ (necessário p/ Sanctum)

    /*
    |--------------------------------------------------------------------------
    | CORS Preflight Responses
    |--------------------------------------------------------------------------
    |
    | Someties CORS preflight requests can be complex. You may wish to
    | specify default headers that should be returned on all preflight
    | requests for your application. The `Access-Control-Allow-Headers`
    | and `Access-Control-Allow-Methods` headers are already handled.
    |
    */

    'preflight_headers' => [
        'Access-Control-Allow-Headers' => '*',
        'Access-Control-Allow-Methods' => '*',
        'Access-Control-Allow-Origin' => '*',
    ],

    /*
    |--------------------------------------------------------------------------
    | CORS Preflight Response Cache
    |--------------------------------------------------------------------------
    |
    | When handling complex CORS preflight requests, you may wish to cache
    | the response headers. This can be useful for improving performance
    | on subsequent requests. The `preflight_cache_ttl` value specifies
    | the number of seconds the response should be cached.
    |
    */

    'preflight_cache_ttl' => 60 * 60 * 24, // 24 hours

    /*
    |--------------------------------------------------------------------------
    | Default CORS Profile
    |--------------------------------------------------------------------------
    |
    | This profile will be used when no specific path match is found.
    | You may configure this profile as needed, but it's recommended
    | to keep the default settings for security reasons.
    |
    */

    'default' => [
        'allowed_origins' => [],
        'allowed_headers' => [],
        'allowed_methods' => [],
        'exposed_headers' => [],
        'max_age' => 0,
        'supports_credentials' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Handle Preflight Requests
    |--------------------------------------------------------------------------
    |
    | This option determines whether the CORS middleware should handle
    | preflight requests. When set to `true`, the middleware will
    | automatically respond to OPTIONS requests with a 204 No Content
    | response, along with the appropriate CORS headers.
    |
    */

    'handle_preflight_requests' => true,

    /*
    |--------------------------------------------------------------------------
    | Preflight Response Status
    |--------------------------------------------------------------------------
    |
    | This option determines the HTTP status code that should be returned
    | for preflight requests. By default, this is set to 204 No Content,
    | but you may change this to 200 OK if needed.
    |
    */

    'preflight_response_status' => Response::HTTP_NO_CONTENT, // 204

];