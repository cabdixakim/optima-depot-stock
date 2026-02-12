<?php

namespace Tests\Feature;

use Tests\TestCase;
use Optima\DepotStock\Models\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClientTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    // Test that the client list page loads and displays clients
    public function client_list_can_be_viewed()
    {
        Client::factory()->count(3)->create();
        $response = $this->get(route('clients.index'));
        $response->assertStatus(200);
        $response->assertViewIs('clients.index');
        $response->assertSee('Client list');
        $response->assertSee(Client::first()->name); // Assert at least one client name is visible
    }

    /** @test */
    // Test that a client can be created via POST
    public function client_can_be_created()
    {
        $data = [
            'name' => 'Test Client',
            'email' => 'client@example.com',
        ];
        $response = $this->post(route('clients.store'), $data);
        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('clients.index'));
        $this->assertDatabaseHas('clients', ['email' => 'client@example.com']);
    }

    /** @test */
    // Test that a client can be updated via PUT
    public function client_can_be_updated()
    {
        $client = Client::factory()->create(['name' => 'Old Name']);
        $data = ['name' => 'Updated Name'];
        $response = $this->put(route('clients.update', $client), $data);
        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('clients.index'));
        $this->assertDatabaseHas('clients', ['name' => 'Updated Name']);
    }

    /** @test */
    // Test that a client can be deleted via DELETE
    public function client_can_be_deleted()
    {
        $client = Client::factory()->create();
        $response = $this->delete(route('clients.destroy', $client));
        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('clients.index'));
        $this->assertDatabaseMissing('clients', ['id' => $client->id]);
    }
}
