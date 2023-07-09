<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $path = storage_path('app/public/uplaods/images/post');
        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
        }
        $this->call(AdminUserSeeder::class);
    }
}
