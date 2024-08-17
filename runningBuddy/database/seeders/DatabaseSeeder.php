<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Itinerary;
use App\Models\Comment;
use App\Models\Plan;
use App\Models\User;
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
        User::truncate();
        Plan::truncate();
        Comment::truncate();
        Itinerary::truncate();

        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $plan1 = Plan::factory()->create([
            'user_id' => $user1->id
        ]);
        $plan2 = Plan::factory()->create([
            'user_id' => $user1->id
        ]);
        $plan3 = Plan::factory()->create([
            'user_id' => $user2->id
        ]);

        Comment::factory()->create([
            'user_id' => $user1->id,
            'plan_id' => $plan3->id,
        ]);
        Comment::factory()->create([
            'user_id' => $user2->id,
            'plan_id' => $plan1->id,
        ]);

        Itinerary::factory()->create([
            'user_id' => $user1->id,
            'plan_id' => $plan1->id,
        ]);
        Itinerary::factory()->create([
            'user_id' => $user1->id,
            'plan_id' => $plan2->id,
        ]);
        Itinerary::factory()->create([
            'user_id' => $user1->id,
            'plan_id' => $plan3->id,
        ]);
        Itinerary::factory()->create([
            'user_id' => $user2->id,
            'plan_id' => $plan1->id,
        ]);
        Itinerary::factory()->create([
            'user_id' => $user2->id,
            'plan_id' => $plan3->id,
        ]);
    }
}
