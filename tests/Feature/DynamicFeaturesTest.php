<?php

namespace Tests\Feature;

use App\Models\Scan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DynamicFeaturesTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_history_can_be_filtered_and_exported(): void
    {
        $user = User::factory()->create();
        Scan::create(['user_id' => $user->id, 'image_path' => 'scans/obat.jpg', 'type' => 'obat', 'status' => 'accepted']);
        Scan::create(['user_id' => $user->id, 'image_path' => 'scans/luka.jpg', 'type' => 'luka', 'status' => 'rejected']);

        $this->actingAs($user)->get(route('history.index', ['type' => 'obat']))
            ->assertOk()
            ->assertSee('Scan Obat')
            ->assertDontSee('Scan Luka');

        $this->actingAs($user)->get(route('history.export', ['type' => 'obat']))
            ->assertStatus(200)
            ->assertHeader('content-type', 'text/csv; charset=UTF-8');
    }

    public function test_admin_pages_use_database_data_and_filters(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create(['role' => 'user']);
        Scan::create(['user_id' => $user->id, 'image_path' => 'scans/obat.jpg', 'type' => 'obat', 'status' => 'accepted']);

        $this->actingAs($admin)->get(route('admin.dashboard'))->assertOk()->assertSee('Total AI scan');
        $this->actingAs($admin)->get(route('admin.monitoring', ['status' => 'accepted']))
            ->assertOk()
            ->assertSee('obat');
        $this->actingAs($admin)->get(route('admin.users', ['search' => $user->email]))
            ->assertOk()
            ->assertSee($user->email);
        $this->actingAs($admin)->get(route('admin.reports'))->assertOk()->assertSee('Distribusi scan');
    }
}
