<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Apartment;

class ApartmentFieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $apartmant = Apartment::first();
        $apartmant->fields()->create([
            'key'   =>  'number_of_bedrooms',
            'value' =>  3,
        ]);
        $apartmant->fields()->create([
            'key'   =>  'has_parking',
            'value' =>  1,
        ]);
    }
}
