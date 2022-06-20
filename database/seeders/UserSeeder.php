<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => '片平 貴順',
            'email' => 't.katahira@warm.co.jp',
            'password' => bcrypt('katahira134'),
        ]);
        User::create([
            'name' => '村上 弘明',
            'email' => 'h.murakami@test.com',
            'password' => bcrypt('warm1111'),
        ]);
        User::create([
            'name' => '大山 勇',
            'email' => 'i.ooyama@test.com',
            'password' => bcrypt('warm1111'),
        ]);
        User::create([
            'name' => '村上 克也',
            'email' => 'k.murakami@test.com',
            'password' => bcrypt('warm1111'),
        ]);
        User::create([
            'name' => '村上 裕也',
            'email' => 'y.murakami@test.com',
            'password' => bcrypt('warm1111'),
        ]);
        User::create([
            'name' => '大泉 一弘',
            'email' => 'k.ooizumi@test.com',
            'password' => bcrypt('warm1111'),
        ]);
        User::create([
            'name' => '木村 康洋',
            'email' => 'y.kimura@test.com',
            'password' => bcrypt('warm1111'),
        ]);
        User::create([
            'name' => '並木 拓',
            'email' => 't.namiki@test.com',
            'password' => bcrypt('warm1111'),
        ]);
        User::create([
            'name' => '五十嵐 一之',
            'email' => 'k.igarashi@test.com',
            'password' => bcrypt('warm1111'),
        ]);
    }
}
