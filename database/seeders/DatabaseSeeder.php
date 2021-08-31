<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Setting::create(["key"=>"newsapi_url","value"=>"https://newsapi.org/v2/"]);
        Setting::create(["key"=>"newsapi_key","value"=>"8b7bc7b92f8a4b59bbb0a9a5424c0d61"]);
        Setting::create(["key"=>"newsapi_query","value"=>"bitcoin OR crypto OR ethereum"]);
    }
}
