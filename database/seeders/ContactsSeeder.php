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
        Contact::create(['name' => 'E-mail', 'type' => 'email']);
        Contact::create(['name' => 'Teléfono', 'type' => 'phone']);
        Contact::create(['name' => 'Pàgina Web', 'type' => 'webpage']);
    }
}
