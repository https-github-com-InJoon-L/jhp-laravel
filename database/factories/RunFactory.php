<?php

namespace Database\Factories;

use App\Models\Run;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RunFactory extends Factory
{

    protected $users = null;

    public function __construct()
    {
        parent::__construct();
        $this->users = User::all();
    }
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Run::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->users->random()->id,
            'countRun' => $this->faker->numberBetween(1, 20),
            'totalRun' => $this->faker->numberBetween(1, 100),
        ];
    }
}
