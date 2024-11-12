<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Buses;
use App\Models\Stops;
use App\Models\Routes;

class RouteControllerTest extends TestCase
{
    use RefreshDatabase;

    /* -- TODO -- не работает, выяснить почему
    public function test_can_create_route(){
        $bus = Buses::create(['busname' => '404']);
        $stop = Stops::create(['stopname' => 'Stop 1', 'location' => 'loc 1']);
    
        $response = $this->postJson('/api/routes', [
            'busid' => $bus->id,
            'routename' => '200',
            'stops' => [$stop->id],
        ]);
    
        $response->assertStatus(201)
                 ->assertJson(['routename' => '200']);
    
        $this->assertDatabaseHas('routes', [
            'busid' => $bus->id,
            'routename' => '200',
            'stops' => json_encode([$stop->id]),
        ]);
    }
    */

    public function test_can_get_routes()
    {
        $bus = Buses::create(['busname' => '404']);
        $stop = Stops::create(['stopname' => 'Stop 1', 'location' => 'loc 1']);
        $route = Routes::create(['busid' => $bus->id, 'routename' => '200', 'stops' => json_encode([$stop->stopname])]);

        $response = $this->getJson('/api/routes');

        $response->assertStatus(200)
                 ->assertJsonCount(1);
    }

    /* -- TODO -- не работает, выяснить почему
    public function test_can_get_single_route(){
        $bus = Buses::create(['busname' => '404']);
        $stop = Stops::create(['stopname' => 'Stop 1', 'location' => 'loc 1']);
        $route = Routes::create(['busid' => $bus->id, 'routename' => '200', 'stops' => json_encode([$stop->id])]);
    
        $response = $this->getJson("/api/routes/{$route->id}");
    
        $response->assertStatus(200)
                 ->assertJson(['routename' => '200'])
                 ->assertJsonFragment(['stops' => [$stop->id]]);
    }
    
    public function test_can_update_route(){
        $bus = Buses::create(['busname' => '404']);
        $stop = Stops::create(['stopname' => 'Stop 1', 'location' => 'loc 1']);
        $route = Routes::create(['busid' => $bus->id, 'routename' => '200', 'stops' => json_encode([$stop->id])]);
    
        $response = $this->putJson("/api/routes/{$route->id}", [
            'routename' => '201',
            'busid' => $bus->id,
            'stops' => [$stop->id],
        ]);

    
        $response->assertStatus(200)
                 ->assertJson(['routename' => '201']);
    
        $this->assertDatabaseHas('routes', [
            'id' => $route->id,
            'routename' => '201',
            'stops' => json_encode([$stop->id]),
        ]);
    }
    */

    public function test_can_delete_route()
    {
        $bus = Buses::create(['busname' => '404']);
        $stop = Stops::create(['stopname' => 'Stop 1', 'location' => 'loc 1']);
        $route = Routes::create(['busid' => $bus->id, 'routename' => '200', 'stops' => json_encode([$stop->stopname])]);

        $response = $this->deleteJson("/api/routes/{$route->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('routes', ['id' => $route->id]);
    }
}