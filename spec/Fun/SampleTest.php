<?php

use Fun\Sample;

class SampleTest extends PHPUnit_Framework_TestCase
{
    public function testSample()
    {
        $sample = new Sample();

        $this->assertInstanceOf(Sample::class, $sample);
    }
}