<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contact;

class ContactsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Contact::create(['type' => 'E-mail']);
        Contact::create(['type' => 'Teléfono']);
        Contact::create(['type' => 'Uber Eats']);
    }
}
