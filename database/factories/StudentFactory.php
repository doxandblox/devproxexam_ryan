<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $date = \Carbon\Carbon::createFromDate(date('Y-m-d H:i:s', mt_rand(1262055681,1262055681)))->toDateTimeString();
        $national_id =  rand(pow(10, 7-1), pow(10, 7)-1);
        return [
            'name' => $this->faker->firstName(),
            'surname' => $this->faker->lastName(),
            'national_id' => $national_id,
            'dob'=>$date,
            'updated_at' => null,
            'created_at' =>  now(),
        ];
    }
}
