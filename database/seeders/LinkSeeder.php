<?php

namespace Database\Seeders;

use App\Models\Link;
use App\Models\card;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LinkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cards = card::all();

        $cards->each(function ($card) {
            Link::factory()
                ->count(3) 
                ->create(['card_id' => $card->id]);
        });
    }
}
