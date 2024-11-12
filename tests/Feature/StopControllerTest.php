<?php

namespace Tests\Feature;

use App\Models\Stops;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StopControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_stop(){
        $response = $this->postJson('/api/stops', [
            'stopname' => 'Stop 1',
            'location' => 'loc 1'
        ]);

        $response->assertStatus(201)
                 ->assertJson(['stopname' => 'Stop 1']);
    }

    public function test_can_get_stops(){
        Stops::create([
            'stopname' => 'Stop 1',
            'location' => 'loc 1'
        ]);

        $response = $this->getJson('/api/stops');

        $response->assertStatus(200)
                 ->assertJsonCount(1);
    }

    public function test_can_get_single_stop(){
        $stop = Stops::create([
            'stopname' => 'Stop 1',
            'location' => 'loc 1'
            ]);

        $response = $this->getJson("/api/stops/{$stop->id}");

        $response->assertStatus(200)
                 ->assertJson([
                    'stopname' => 'Stop 1',
                    ]);
    }

    public function test_can_update_stop(){
        $stop = Stops::create([
                'stopname' => 'Stop 1',
                'location' => 'loc 1'
                ]);

        $response = $this->putJson("/api/stops/{$stop->id}", [
            'stopname' => 'Updated Stop',
            'location' => 'Updated Loc'
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                    'stopname' => 'Updated Stop',
                    'location' => 'Updated Loc'
                    ]);
    }

    public function test_can_delete_stop(){
        $stop = Stops::create([
            'stopname' => 'Stop 1',
            'location' => 'loc 1'
        ]);

        $response = $this->deleteJson("/api/stops/{$stop->id}"); 

        $response->assertStatus(204);
        $this->assertDatabaseMissing('stops', ['id' => $stop->id]);
    }
}
