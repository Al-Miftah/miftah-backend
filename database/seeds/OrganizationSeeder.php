<?php

use App\Models\User;
use App\Models\Organization;
use Illuminate\Database\Seeder;

/**
 * @author Ibrahim Samad <naatogma@gmail.com>
 */
class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $organizations = [
            [
                'name' => 'Wa Central Mosque',
                'digital_address' => 'XW-0005-9319',
                'about' => 'Wa central mosque',
                'phone_number' => '+233240000000',
                'logo_url' => 'https://afrotourism.com/wp-content/uploads/2015/07/CentralMosque1.jpg',
                'creator_id' => User::first()->id,
            ]
        ];
        
        foreach ($organizations as $organization) {
            Organization::firstOrCreate(['name' => $organization['name']], [
                'digital_address' => $organization['digital_address'],
                'about' => $organization['about'],
                'phone_number' => $organization['phone_number'],
                'logo_url' => $organization['logo_url'],
                'creator_id' => User::first()->id,
            ]);
        }
    }
}
