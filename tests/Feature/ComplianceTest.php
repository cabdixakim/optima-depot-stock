<?php

namespace Tests\Feature;

use Tests\TestCase;

class ComplianceTest extends TestCase
{
    /**
     * Test compliance dashboard can be viewed.
     */
    public function test_compliance_dashboard_can_be_viewed(): void
    {
        $response = $this->get('/compliance');
        $response->assertStatus(200);
    }

    /**
     * Test compliance record can be created.
     */
    public function test_compliance_record_can_be_created(): void
    {
        $data = [ 'type' => 'inspection', 'status' => 'passed' ];
        $response = $this->post('/compliance', $data);
        $response->assertStatus(302);
    }
}
