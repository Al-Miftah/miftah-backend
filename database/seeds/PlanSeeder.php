<?php

use App\Models\Plan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

/**
 * @author Ibrahim Samad <naatogma@gmail.com>
 */
class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $plans = [
            [
                'name' => 'GH₵ 50 Monthly',
                'plan_code' => [
                    'test' => 'PLN_d8fc6gdpgdeo1qf',
                    'live' => '',
                ],
                'description' => 'Donate 50 cedis every month',
            ],
            [
                'name' => 'GH₵ 100 Monthly',
                'plan_code' => [
                    'test' => 'PLN_m0upait6z9wicfn',
                    'live' => '',
                ],
                'description' => 'Donate 100 cedis every month',
            ],
            [
                'name' => 'GH₵ 150 Monthly',
                'plan_code' => [
                    'test' => 'PLN_hinex7jgrzqkjk8',
                    'live' => '',
                ],
                'description' => 'Donate 150 cedis every month',
            ],
            [
                'name' => 'GH₵ 200 Monthly',
                'plan_code' => [
                    'test' => 'PLN_r3d5fr9xjn4vpgq',
                    'live' => '',
                ],
                'description' => 'Donate 200 cedis every month',
            ]
        ];

        foreach ($plans as $plan) {
            $code = (App::environment() == 'production') ? $plan['plan_code']['live'] : $plan['plan_code']['test'];
            Plan::firstOrCreate(['name' => $plan['name']], [
                'plan_code' => $code,
                'description' => $plan['description']
            ]);
        }
    }
}
