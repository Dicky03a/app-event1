<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class EventLifecycleTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\RolePermissionSeeder::class);
    }

    public function test_admin_can_create_event()
    {
        $organization = Organization::create(['name' => 'Test Org', 'slug' => 'test-org']);
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => Hash::make('password'),
            'organization_id' => $organization->id,
        ]);
        $admin->assignRole('admin');

        $response = $this->actingAs($admin)
            ->withoutMiddleware() // Skip CSRF verification for this test
            ->post(route('admin.events.store'), [
                'title' => 'Test Event',
                'description' => 'Description',
                'event_date' => '2025-01-01',
                'event_time' => '10:00',
                'location' => 'Venue',
            ]);

        $response->assertRedirect(route('admin.events.index'));
        $this->assertDatabaseHas('events', [
            'title' => 'Test Event',
            'status' => 'pending',
            'organization_id' => $organization->id,
        ]);
    }

    public function test_superadmin_can_approve_event()
    {
        $organization = Organization::create(['name' => 'Test Org', 'slug' => 'test-org']);
        $creator = User::create([
            'name' => 'Creator',
            'email' => 'creator@test.com',
            'password' => Hash::make('password'),
            'organization_id' => $organization->id,
        ]);

        $event = Event::create([
            'organization_id' => $organization->id,
            'created_by' => $creator->id,
            'title' => 'Pending Event',
            'slug' => 'pending-event',
            'description' => 'Desc',
            'event_date' => '2025-01-01',
            'event_time' => '10:00',
            'location' => 'Venue',
            'status' => 'pending',
        ]);

        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'super@test.com',
            'password' => Hash::make('password'),
        ]);
        $superAdmin->assignRole('super-admin');

        $response = $this->actingAs($superAdmin)
            ->withoutMiddleware() // Skip CSRF verification for this test
            ->post(route('super.events.approve', $event));

        $response->assertRedirect(route('super.events.pending'));
        $this->assertDatabaseHas('events', [
            'id' => $event->id,
            'status' => 'published',
        ]);
    }

    public function test_public_can_view_published_event()
    {
        $organization = Organization::create(['name' => 'Test Org', 'slug' => 'test-org']);
        $creator = User::create([
            'name' => 'Creator',
            'email' => 'creator@test.com',
            'password' => Hash::make('password'),
            'organization_id' => $organization->id,
        ]);

        $event = Event::create([
            'organization_id' => $organization->id,
            'created_by' => $creator->id,
            'title' => 'Published Event',
            'slug' => 'published-event',
            'description' => 'Desc',
            'event_date' => '2025-01-01',
            'event_time' => '10:00',
            'location' => 'Venue',
            'status' => 'published',
        ]);

        $response = $this->get(route('events.show', $event->slug));

        $response->assertStatus(200);
        $response->assertSee('Published Event');
    }

    public function test_public_cannot_view_pending_event()
    {
        $organization = Organization::create(['name' => 'Test Org', 'slug' => 'test-org']);
        $creator = User::create([
            'name' => 'Creator',
            'email' => 'creator@test.com',
            'password' => Hash::make('password'),
            'organization_id' => $organization->id,
        ]);

        $event = Event::create([
            'organization_id' => $organization->id,
            'created_by' => $creator->id,
            'title' => 'Pending Event',
            'slug' => 'pending-event',
            'description' => 'Desc',
            'event_date' => '2025-01-01',
            'event_time' => '10:00',
            'location' => 'Venue',
            'status' => 'pending',
        ]);

        $response = $this->get(route('events.show', $event->slug));

        $response->assertStatus(404);
    }
}
