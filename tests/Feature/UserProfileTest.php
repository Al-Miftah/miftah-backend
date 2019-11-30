<?php

namespace Tests\Feature;

use Storage;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
class UserProfileTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * @test
     */
    public function it_shows_profile_details_of_user()
    {
        $user = factory('App\Models\User')->create([
            'name' => 'Abdul Samad'
        ]);
        $this->authenticate($user);

        $response = $this->json('GET', route('user.profile.show'));
        $response->assertOk();
        $response->assertJsonFragment([
            'name' => 'Abdul Samad'
        ]);
    }

    /**
     * @test
     */
    public function it_updates_profile_details_of_a_user()
    {
        $user = factory('App\Models\User')->create([
            'name' => 'Abdul Samad'
        ]);
        $this->authenticate($user);

        $input = [
            'username' => 'ultrasamad'
        ];
        $response = $this->json('PATCH', route('user.profile.update'), $input);
        $response->assertOk();
        $response->assertJsonFragment([
            'username' => 'ultrasamad'
        ]);
    }

    /**
     * @test
     */
    public function it_updates_profile_picture_of_user()
    {
        Storage::fake('local');

        $user = factory('App\Models\User')->create([
            'name' => 'Abdul Samad'
        ]);
        $this->authenticate($user);

        $input = [
            'avatar' => UploadedFile::fake()->image('myface.png'),
        ];
        $response = $this->json('PATCH', route('user.profile.update'), $input);
        $response->assertOk();
        $folder = 'public/uploads/profile';
        $this->assertCount(1, Storage::files($folder));
    }

    /**
     * @test
     */
    public function it_changes_user_password()
    {
        $user = factory('App\Models\User')->create([
            'name' => 'Abdul Samad',
            'password' => bcrypt('lovetheworld'),
        ]);
        $this->authenticate($user);
        $input = [
            'current_password' => 'lovetheworld',
            'password' => 'hatetheworld',
            'password_confirmation' => 'hatetheworld'
        ];
        $response = $this->json('PATCH', route('user.password.update'), $input);
        $response->assertOk();
        $response->assertJsonFragment([
            'message'   => 'Password changed successfully!'
        ]);
    }
}
