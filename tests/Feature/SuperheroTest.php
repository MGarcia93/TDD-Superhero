<?php

namespace Tests\Feature;

use App\Enum\Creator;
use App\Models\Superhero;
use App\Models\Superpower;
use Database\Seeders\SuperpowerSeeder;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class SuperheroTest extends TestCase
{
    use RefreshDatabase;
    protected $faker;

    /**
     * Sets up the tests
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->faker = Factory::create();

        Artisan::call('migrate'); // runs the migration
        $this->seed(SuperpowerSeeder::class);
    }

    /** @test*/
    public function canCreateASuperHero()
    {
        $superpowers = Superpower::inRandomOrder()
            ->limit($this->faker->numberBetween(1, 3))
            ->get();
        $data = [
            'name' => $this->faker->sentence,
            'history' => $this->faker->paragraph,
            'creator' => $this->faker->randomElements(array_column(Creator::cases(), 'value'))[0],
            'superpowers' => array_map(function ($power) {
                return $power['id'];
            }, $superpowers->toArray())
        ];

        $response = $this->json('POST', '/api/superhero', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('superheroes', [
            'name' => $data['name'],
            'history' => $data['history'],
            'creator' => $data['creator']
        ]);
        $hero = Superhero::where('name', $data['name'])->where('history', $data['history'])->get()->first();
        array_map(function ($power) use ($hero) {
            $this->assertDatabaseHas('superpowers_superheroes', [
                'superpower_id' => $power['id'],
                'superhero_id' => $hero->id
            ]);
        }, $superpowers->toArray());
    }

    /** @test */
    public function ErrorInCreateASuperheroForWithoutField()
    {
        $data = [
            'name' => $this->faker->sentence,
            'creator' => $this->faker->randomElements(array_column(Creator::cases(), 'value'))[0]
        ];
        $response = $this->json('POST', '/api/superhero', $data);
        $response->assertStatus(422);
    }
}
