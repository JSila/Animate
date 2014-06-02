<?php namespace JSila\Animate\Session;

use Illuminate\Session\Store;

class IlluminateSession implements SessionInterface {

    protected $session;

    function __construct(Store $session)
    {
        $this->session = $session;
    }

    public function put($key, $value)
    {
        $this->session->put($key, $value);
    }

    public function get($name, $default = null)
    {
        return $this->session->get($name, $default);
    }
}
