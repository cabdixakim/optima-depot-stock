<?php

namespace Tests\Feature;

use Tests\TestCase;

class PaymentTest extends TestCase
{
    /**
     * Test payment can be created.
     */
    public function test_payment_can_be_created(): void
    {
        $data = [ 'invoice_id' => 1, 'amount' => 1000 ];
        $response = $this->post('/payments', $data);
        $response->assertStatus(302);
    }
}
