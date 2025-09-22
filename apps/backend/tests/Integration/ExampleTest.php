<?php

namespace Tests\Integration;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ExampleTest extends KernelTestCase
{
    public function testExample() {
        self::bootKernel();

        $this->assertTrue(true);
    }
}
