<?php

/**
 * ---------------------------------------------------------------------
 * THIS IS $allowed_origins code IS NOT PART OF THE ORIGINAL CORS PACKAGE.
 * IT IS A MODIFICATION BY Asset-IT TO ALLOW ADDING ALLOWED ORIGINS VIA THE ENV.
 * ---------------------------------------------------------------------
 *
 * Since we don't really want people editing config files (lest they get
 * overwritten later), this enables the person managing the Asset-IT
 * installation to modify these values without modifying the code.
 *
 * If APP_CORS_ALLOWED_ORIGINS is not set in the .env (for example if no one added it
 * after an upgrade from a previous version that didn't include it in the .env.example) or is null,
 * set it to * to allow all. If there is a value, either a single url or a comma-delimited
 * list of urls, explode that out into an array to whitelist just those urls.
 */

$allowed_origins = env('CORS_ALLOWED_ORIGINS') !== null ?
    explode(',', env('CORS_ALLOWED_ORIGINS')) : [];

/**
 * Original Laravel CORS package config file modifications end here
 *
 */


return [

    /*
    |--------------------------------------------------------------------------
    | Laravel CORS
    |--------------------------------------------------------------------------
    |
    | allowedOrigins, allowedHeaders and allowedMethods can be set to array('*')
    | to accept any value.
    |
    */
   
    'supportsCredentials' => false,
    'allowedOrigins' => $allowed_origins,
    'allowedOriginsPatterns' => [],
    'allowedHeaders' => ['*'],
    'allowedMethods' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE'],
    'exposedHeaders' => [],
    'maxAge' => 0,

];
