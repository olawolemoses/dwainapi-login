<?php

namespace Dwaincore\Authmgt\Tests;

class ExampleTest extends TestCase
{
    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }

    /** @test */
    public function it_can_display_the_route_from_auth()
    {
        $this
            ->get('authentication')
            ->assertOk();
    }
}
