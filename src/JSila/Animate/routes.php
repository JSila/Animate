<?php

Route::get(Config::get('animate::config.custom_classes_stylesheet_url'), function()
{
    return Response::make(Animate::generateCSS(), 200, [
        'Content-Type' => 'text/css; charset: UTF-8'
    ]);
});
