<?php

namespace Tests\Feature;

use App\Models\Buses;
use App\Models\Routes;
use App\Models\Stops;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FindControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void{
        parent::setUp();
        $this->setUpTestData();
    }

    protected function setUpTestData(){
        $bus1 = Buses::factory()->create(['busname' => '№11']);
        $bus2 = Buses::factory()->create(['busname' => '№21']);

        $stop1 = Stops::factory()->create(['stopname' => 'ул. Пушкина', 'location' => '01']);
        $stop2 = Stops::factory()->create(['stopname' => 'ул. Ленина', 'location' => '02']);
        $stop3 = Stops::factory()->create(['stopname' => 'ост. Попова', 'location' => '03']);

        $route1 = Routes::create([
            'routename' => 'Маршрут А',
            'busid' => $bus1->id,
            'stops' => json_encode([$stop1->id, $stop3->id])
        ]);

        $route2 = Routes::create([
            'routename' => 'Маршрут Б',
            'busid' => $bus2->id,
            'stops' => json_encode([$stop2->id, $stop3->id])
        ]);
    }

    public function testFindBus(){
        $response = $this->get('/api/find-bus?from=1&to=2'); // 1 - ул. Пушкина, 2 - ул. Ленина

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'from',
                     'to',
                     'buses' => [
                         '*' => [
                             'route',
                             'next_arrivals',
                         ],
                     ],
                 ])
                 ->assertJson([
                     'from' => 'ул. Пушкина',
                     'to' => 'ул. Ленина',
                 ]);
    }

    public function test_update_route(){
        $user = User::factory()->create();
        $this->actingAs($user);
    
        $bus = Buses::first();
        $stop1 = Stops::where('stopname', 'ул. Пушкина')->first();
        $stop2 = Stops::where('stopname', 'ост. Попова')->first();
    
        $route = Routes::create([
            'routename' => 'Маршрут Обновленный',
            'busid' => $bus->id,
            'stops' => json_encode([$stop1->id, $stop2->id]),
        ]);
    
        $response = $this->postJson('/api/routes/update/' . $route->id, [
            'routename' => 'New Route Name',
            'busid' => $bus->id,
            'stops' => [$stop1->id, $stop2->id],
        ]);
    
        $response->assertStatus(200);
    
        $this->assertDatabaseHas('routes', [
            'id' => $route->id,
            'busid' => $bus->id,
            'routename' => 'New Route Name',
        ]);
    
        $updatedRoute = Routes::find($route->id);
    
        $this->assertTrue(
            in_array($stop1->id, json_decode($updatedRoute->stops)) &&
            in_array($stop2->id, json_decode($updatedRoute->stops)),
            'Updated stops do not match.'
        );
    }
    
    
    

    public function test_update_route_with_invalid_routename(){

        $user = User::factory()->create();
        $this->actingAs($user);

        $bus = Buses::factory()->create();
        $route = Routes::factory()->create(['busid' => $bus->id]);

        $response = $this->postJson('/api/routes/update/' . $route->id, [
            'routename' => '',
            'busid' => $bus->id,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['routename']);
    }
}