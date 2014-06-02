<?php namespace JSila\Animate\Session;

interface SessionInterface {

    public function put($key, $value);
    public function get($name, $default = null);
}
