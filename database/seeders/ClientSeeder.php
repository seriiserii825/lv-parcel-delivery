<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clients = [
            ['name' => 'Blueline'],
            ['name' => 'Alutofianco'],
            ['name' => 'Rewind']
        ];

        foreach ($clients as $client) {
            \App\Models\Client::create($client);
        }
    }
}
