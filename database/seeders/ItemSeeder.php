<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            [
                'item_name' => "Item 1",
                'start_price' => 10000,
                'item_desc' => 'Item blbalbal',
            ],
            [
                'item_name' => "Item 2",
                'start_price' => 20000,
                'item_desc' => 'Item blbalbal',
            ],
            [
                'item_name' => "Item 3",
                'start_price' => 30000,
                'item_desc' => 'Item blbalbal',
            ],
        ];

        Item::insert($items);
    }
}
