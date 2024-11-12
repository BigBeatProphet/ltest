<?php

namespace Tests\Feature;

use App\Models\Buses;
use App\Models\Stops;
use App\Models\Schedules;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ScheduleControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_schedule(){
        $bus = Buses::create(['busname' => '404']);
        $stop = Stops::create(['stopname' => 'Stop 1', 'location' => 'loc 1']);

        $response = $this->postJson('/api/schedules', [
            'busid' => $bus->id,
            'stopid' => $stop->id,
            'arrivaltime' => '10:00',
        ]);

        $response->assertStatus(201)
                 ->assertJson(['arrivaltime' => '10:00']);
    }

    public function test_can_get_schedules(){
        $bus = Buses::create(['busname' => '404']);
        $stop = Stops::create(['stopname' => 'Stop 1', 'location' => 'loc 1']);
        Schedules::create(['busid' => $bus->id, 'stopid' => $stop->id, 'arrivaltime' => '10:00']);

        $response = $this->getJson('/api/schedules');

        $response->assertStatus(200)
                 ->assertJsonCount(1);
    }

    public function test_can_get_single_schedule(){
        $bus = Buses::create(['busname' => '404']);
        $stop = Stops::create(['stopname' => 'Stop 1', 'location' => 'loc 1']);
        $schedule = Schedules::create(['busid' => $bus->id, 'stopid' => $stop->id, 'arrivaltime' => '10:00:00']);

        $response = $this->getJson("/api/schedules/{$schedule->id}");

        $response->assertStatus(200)
                 ->assertJson(['arrivaltime' => '10:00:00']);
    }

    public function test_can_update_schedule(){
        $bus = Buses::create(['busname' => '404']);
        $stop = Stops::create(['stopname' => 'Stop 1', 'location' => 'loc 1']);
        $schedule = Schedules::create(['busid' => $bus->id, 'stopid' => $stop->id, 'arrivaltime' => '10:00']);

        $response = $this->putJson("/api/schedules/{$schedule->id}", [
            'arrivaltime' => '11:00',
        ]);

        $response->assertStatus(200)
                 ->assertJson(['arrivaltime' => '11:00']);
    }

    public function test_can_delete_schedule(){
        $bus = Buses::create(['busname' => '404']);
        $stop = Stops::create(['stopname' => 'Stop 1', 'location' => 'loc 1']);
        $schedule = Schedules::create(['busid' => $bus->id, 'stopid' => $stop->id, 'arrivaltime' => '10:00']);

        $response = $this->deleteJson("/api/schedules/{$schedule->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('schedules', ['id' => $schedule->id]);
    }
}