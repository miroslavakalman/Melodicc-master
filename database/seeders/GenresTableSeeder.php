<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GenresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
public function run()
{
    collect(['Rock','Pop','Hip-Hop','Jazz','Electronic'])->each(fn($name) =>
        \App\Models\Genre::firstOrCreate(['name'=>$name])
    );
}

}
