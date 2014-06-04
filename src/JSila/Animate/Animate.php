<?php namespace JSila\Animate;

use JSila\Animate\Session\SessionInterface;
use JSila\Animate\Response\ResponseInterface;


class Animate {

    /**
     * @var \Illuminate\Session\Store
     */
    protected $session;

    /**
     * @var array
     */
    private $customClasses = [];

    /**
     * @var array
     */
    protected $animationProperties = [
        'duration',
        'delay',
        'direction',
        'iteration-count'
    ];

    /**
     * @param Store $session
     */
    function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * @param array $animationProperties
     */
    public function setAnimationProperties($animationProperties)
    {
        $this->animationProperties = $animationProperties;
    }

    /**
     * @return array
     */
    public function getAnimationProperties()
    {
        return $this->animationProperties;
    }

    /**
     * @param $animation
     * @param $args
     * @return string
     */
    public function __call($animation, $args)
    {
        $classString[] = "animated $animation";

        if($args)
        {
            $options = $args[0];
    
            $classString[] = $this->addInfiniteClass($options);
    
            foreach ($this->animationProperties as $animationProperty)
            {
                $classString[] = $this->addAnimationProperty($animationProperty, $options);
            }
        }

        if ($this->customClasses) {
            $this->storeCustomClassesInSession();
        }

        $classString = array_filter($classString, function($value)
        {
            return $value != "";
        });
        
        return implode(' ', $classString);
    }

    /**
     * @return string
     */
    private function addInfiniteClass($options)
    {
        return (isset($options['infinite']) && $options['infinite']) ? 'infinite' : '';
    }

    /**
     * @param $animationProperty
     * @param $options
     * @return string
     */
    private function addAnimationProperty($animationProperty, $options)
    {

        if (isset($options[$animationProperty]))
        {
            $class = "$animationProperty" . str_replace('.', '_', $options[$animationProperty]);
            $this->customClasses[$animationProperty][$class] = $options[$animationProperty];
        }
        else
        {
            $class = "";
        }

        return $class;
    }

    /**
     * @return string
     */
    public function generateCSS()
    {
        $css = '';

        foreach ($this->session->get('classes') as $animationProperty => $classes)
        {
            foreach ($classes as $class => $value)
            {
                $css .= ".$class{animation-$animationProperty:$value;-webkit-animation-$animationProperty:$value;}";
            }
        }

        return $css;
    }

    /**
     * @return void
     */
    private function storeCustomClassesInSession()
    {
        $this->session->put('classes', $this->customClasses);
    }
}
