<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 50000) as $index) { // Ubah angka sesuai jumlah yang diinginkan
            DB::table('products')->insert([
                'name' => $faker->word, // Membuat nama produk acak
                'price' => $faker->numberBetween(10000, 100000), // Harga acak antara 10.000 dan 100.000
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
