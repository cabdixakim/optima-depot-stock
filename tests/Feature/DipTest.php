<?php

namespace Tests\Feature;

use Tests\TestCase;

class DipTest extends TestCase
{
    /**
     * Test dip entry can be created.
     */
    public function test_dip_entry_can_be_created(): void
    {
        $data = [ 'tank_id' => 1, 'volume' => 5000 ];
        $response = $this->post('/dips', $data);
        $response->assertStatus(302);
    }
}
