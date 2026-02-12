<?php

namespace Tests\Feature;

use Tests\TestCase;

class InvoiceTest extends TestCase
{
    /**
     * Test invoice list can be viewed.
     */
    public function test_invoice_list_can_be_viewed(): void
    {
        $response = $this->get('/invoices');
        $response->assertStatus(200);
    }

    /**
     * Test invoice can be created.
     */
    public function test_invoice_can_be_created(): void
    {
        $data = [ 'client_id' => 1, 'amount' => 1000 ];
        $response = $this->post('/invoices', $data);
        $response->assertStatus(302);
    }
}
