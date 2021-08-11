<?php

namespace Database\Factories;

use App\Models\Attend;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttendFactory extends Factory
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
    protected $model = Attend::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->users->random()->id,
            'run' => $this->faker->numberBetween(1, 20),
            'desc_value' => '결석', // '지각', '결석'
            'attend' => $this->faker->date(),
        ];
    }
}
