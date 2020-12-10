<?php

$cloud_name = 'tuffah-informatics';
$api_key = '589447124626131';
$api_secret = 'zkydbj5JLFWjN2XWTETHjH50BBs';

\Cloudinary::config(array(
    'cloud_name' => $cloud_name == '' ? $_ENV['CLOUDINARY_CLOUD_NAME'] : $cloud_name,
    'api_key' => $api_key == '' ? $_ENV['CLOUDINARY_API_KEY'] : $api_key,
    'api_secret' => $api_secret == '' ? $_ENV['CLOUDINARY_API_SECRET'] : $api_secret
));