<?php

namespace Database\Seeders;

use App\Models\Card;
use App\Models\Contact;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cards = Card::all();
        $cards->each(function($card){
            Contact::factory(1)
                    ->create(['card_id' => $card->id]);
        });
    }
}
