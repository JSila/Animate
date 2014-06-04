<?php

use Mockery as m;
use JSila\Animate\Animate;

class AnimateTest extends \PHPUnit_Framework_TestCase {

    public function setUp()
    {
        $this->session = m::mock('JSila\Animate\Session\IlluminateSession');
        $this->animations = new Animate($this->session);
    }
    public function tearDown()
    {
        m::close();
    }

    public function testIsInstantiable()
    {
        $this->assertInstanceOf('JSila\Animate\Animate', $this->animations);
    }

    public function testMakeAnimationWihoutOptions()
    {
        $actual = $this->animations->zoomIn();
        $this->assertEquals("animated zoomIn", $actual);
    }
    
    public function testMakeAnimationWithInfiniteOptionOn()
    {
        $actual = $this->animations->zoomIn(['infinite' => true]);
        $this->assertEquals("animated zoomIn infinite", $actual);
    }
    
    public function testMakeAnimationWithInfiniteOptionOff()
    {
        $actual = $this->animations->slideInDown(['infinite' => false]);
        $this->assertEquals("animated slideInDown", $actual);
    }

    public function testMakeAnimationWithDelayOption()
    {
        $this->session->shouldReceive('put');

        $actual = $this->animations->slideInDown(['delay' => '.1s', 'duration' => '.1s',]);
        $this->assertEquals("animated slideInDown duration_1s delay_1s", $actual);
    }

    public function testGenerateCSSWhenOptionsProvided()
    {
        $this->session->shouldReceive('get')->andReturn([
            'duration' => [
                'duration_3s' => '.3s',
                'duration_1s' => '.1s'
            ],
            'delay' => [
                'delay_3s' => '.3s',
                'delay_1s' => '.1s'
            ]
        ]);
        
        $actual = $this->animations->generateCSS();
        $this->assertEquals(".duration_3s{animation-duration:.3s;-webkit-animation-duration:.3s;}.duration_1s{animation-duration:.1s;-webkit-animation-duration:.1s;}.delay_3s{animation-delay:.3s;-webkit-animation-delay:.3s;}.delay_1s{animation-delay:.1s;-webkit-animation-delay:.1s;}", $actual);
    }
}
