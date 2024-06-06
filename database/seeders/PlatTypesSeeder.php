<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PlatType;

class PlatTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        PlatType::create(['type' => 'Primers']);
        PlatType::create(['type' => 'Segons']);
        PlatType::create(['type' => 'Postres']);        
    }
}
