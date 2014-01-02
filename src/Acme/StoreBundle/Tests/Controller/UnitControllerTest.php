<?php

namespace Acme\StoreBundle\Tests\Controller;

use Acme\StoreBundle\Controller\DefaultController;
class UnitControllerTest extends \PHPUnit_Framework_TestCase
{
    public function testAdd()
    {
        $calc = new DefaultController();
        $result = $calc->add(30, 12);

        // assert that your calculator added the numbers correctly!
        $this->assertEquals(42, $result);
    }
}
