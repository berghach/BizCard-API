<?php

namespace Database\Seeders;

use App\Models\Link;
use App\Models\Contact;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LinkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contacts = Contact::all();

        $contacts->each(function ($contact) {
            Link::factory()
                ->count(3) 
                ->create(['contact_id' => $contact->id]);
        });
    }
}
