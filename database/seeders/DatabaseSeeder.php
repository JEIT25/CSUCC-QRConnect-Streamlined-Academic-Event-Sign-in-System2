<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Event;
use Illuminate\Database\Seeder;
use App\Models\MasterList;
use App\Models\MasterListStudent;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(1)->create(
        //     [
        //         "email" => "admin@example.com",
        //         "type" => "facilitator"
        //     ]
        // );
        

        // User::factory()->create([
        //     'type' => 'facilitator',
        //     'email' => 'test@example.com',
        // ]);


        // Event::factory()->create(
        //     [
        //         'id' => 1,
        //         'user_id' => 1,
        //         'code' => 'test1',
        //         'name' => 'test1',
        //         'description' => 'test1',
        //         'location' => 'test1',
        //         'profile_image' => 'test1',
        //         'is_restricted' => true
        //     ]
        // );

        // Event::factory()->create(
        //     [
        //         'id' => 2,
        //         'user_id' => 2,
        //         'code' => 'test2',
        //         'name' => 'test2',
        //         'description' => 'test2',
        //         'location' => 'test2',
        //         'profile_image' => 'test2',
        //         'is_restricted' => true
        //     ]
        // );

        // MasterList::factory()->create(
        //     [
        //         'user_id' => 1,
        //        'event_id' => 1,
        //        'name' => "Test class attendance masterlist"
        //     ]
        // );

        // MasterListStudent::factory()->create(
        //     [
        //         'user_id' => 2,
        //         'master_list_id' => 1,
        //     ]
        // );
    }
}
