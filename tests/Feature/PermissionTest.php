<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;

class PermissionTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * Setup
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->seed(['RolesAndPermissionsSeeder']);
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_lists_all_permissions()
    {
        $response = $this->getJson(route('permissions.index'));
        $response->assertOk();
    }
}
