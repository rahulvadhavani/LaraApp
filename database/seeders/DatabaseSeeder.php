<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $path = storage_path(User::STORAGE_PATH);
        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
        }
        $this->call(AdminUserSeeder::class);
    }
}
