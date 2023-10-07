<?php

namespace Database\Seeders;

use App\Models\Traveler;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(10)->create();
        Traveler::factory(4500)->create();
        
        $this->call([
            LibrarySeeder::class,
        ]);
    }
}
