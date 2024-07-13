<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'name' => 'Orange Paint Card',
                'description' => 'Some quick example text to build on the card title and make up the bulk of the card\'s content.',
                'price' => '50',
                'image'=> 'img1.jpg'
            ],
            [
                'name' => 'Tea Cup Art',
                'description' => 'Some quick example text to build on the card title and make up the bulk of the card\'s content.',
                'price' => '35',
                'image'=> 'img2.jpg'
            ],
            [
                'name' => 'Leg Tattoo Paint',
                'description' => 'Some quick example text to build on the card title and make up the bulk of the card\'s content.',
                'price' => '65',
                'image'=> 'img3.jpg'
            ]
        ]);
        
    }
}
