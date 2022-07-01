<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CsvImportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(){
        $age = rand(5,95);
        $dob = date('Y/m/d',strtotime("-".rand(18,2022)." years",strtotime(date('Y/m/d'))));
        return [
            'name' => $this->faker->firstName(),
            'surname' => $this->faker->lastName(),
            'age' => $age,
            'dob'=>$dob,
            'updated_at' => null,
            'created_at' =>  now(),
        ];
    }

    public function names($n=1000){
        $arr = [];
        for($i = 0; $i<$n+1; $i++){
            array_push($arr, $this->faker->firstName());
        }
        return $arr;
    }

    public function surname($n){
        $arr = [];
        for($i = 0; $i<$n; $i++){
            array_push($arr, $this->faker->firstName());
        }
        return $arr;
    }
}
