<?php

namespace Tests\Feature;

use Tests\TestCase;

class DashboardTest extends TestCase
{
    /**
     * Test depot dashboard can be viewed.
     */
    public function test_depot_dashboard_can_be_viewed(): void
    {
        $response = $this->get('/dashboard');
        $response->assertStatus(200);
    }
}
