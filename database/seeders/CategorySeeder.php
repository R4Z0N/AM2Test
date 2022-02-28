<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Apartment;

class CategorySeeder extends Seeder
{
    use HasFactory;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::factory(4)->has(Apartment::factory()->count(6))->create();
        Category::factory([
            'parent_id' =>  1,
        ])->has(Apartment::factory()->count(6))->create();
    }
}
