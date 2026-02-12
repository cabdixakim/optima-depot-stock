<?php

namespace Tests\Feature;

use Tests\TestCase;

class PortalTest extends TestCase
{
    /**
     * Test client portal home can be viewed.
     */
    public function test_client_portal_home_can_be_viewed(): void
    {
        $response = $this->get('/portal/home');
        $response->assertStatus(200);
    }
}
