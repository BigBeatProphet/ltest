<?php

namespace Tests\Feature;

use App\Models\Buses;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BusControllerTest extends TestCase
{
    use RefreshDatabase;


    public function test_can_create_bus(){
        $response = $this->postJson('/api/buses', [
            'busname' => '404'
        ]);

        $response->assertStatus(201)
                 ->assertJson(['busname' => '404']);
    }

    public function test_can_get_buses(){
        Buses::create(['busname' => '404']);

        $response = $this->getJson('/api/buses');

        $response->assertStatus(200)
                 ->assertJsonCount(1);
    }

    public function test_can_get_single_bus(){
        $bus = Buses::create(['busname' => '404']);

        $response = $this->getJson("/api/buses/{$bus->id}");

        $response->assertStatus(200)
                 ->assertJson(['busname' => '404']);
    }

    public function test_can_update_bus(){
        $bus = Buses::create(['busname' => '404']);

        $response = $this->putJson("/api/buses/{$bus->id}", [
            'busname' => '201',
        ]);

        $response->assertStatus(200)
                 ->assertJson(['busname' => '201']);
    }

    public function test_can_delete_bus(){
        $bus = Buses::create(['busname' => '404']);

        $response = $this->deleteJson("/api/buses/{$bus->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('buses', ['id' => $bus->id]);
    }
}