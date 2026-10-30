<?php

namespace Tests\Feature;

use App\Models\Chat;
use App\Models\Scan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class PhaseSixSecurityTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_user_cannot_open_another_users_chat(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();
        $scan = Scan::create([
            'user_id' => $owner->id,
            'image_path' => 'scans/example.jpg',
            'type' => 'luka',
            'status' => 'rejected',
        ]);

        $response = $this->actingAs($otherUser)->get(route('chat.index', $scan));

        $response->assertNotFound();
    }

    public function test_a_user_cannot_send_chat_messages_to_another_users_scan(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();
        $scan = Scan::create([
            'user_id' => $owner->id,
            'image_path' => 'scans/example.jpg',
            'type' => 'luka',
            'status' => 'rejected',
        ]);

        $response = $this->actingAs($otherUser)->postJson(
            route('chat.send.scan', $scan),
            ['message' => 'Pesan tidak boleh masuk']
        );

        $response->assertNotFound();
    }

    public function test_scan_rejects_invalid_input_before_calling_ai(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson(route('scan.store'), [
            'notes' => str_repeat('x', 1001),
            'consent_training' => true,
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['image', 'notes']);
    }

    public function test_user_can_send_text_chat_without_an_image(): void
    {
        Http::fake([
        config('services.groq.base_url').'/*' => Http::response([
            'choices' => [
                ['message' => ['content' => 'Jawaban CareBot']],
            ],
        ]),
        ]);

        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson(route('chat.send'), [
        'message' => 'Apa yang harus saya lakukan jika pusing?',
        ]);

        $response->assertOk()->assertJson(['reply' => 'Jawaban CareBot']);
        $this->assertDatabaseHas('chats', [
        'scan_id' => null,
        'sender' => 'user',
        'message' => 'Apa yang harus saya lakukan jika pusing?',
        ]);
        $this->assertDatabaseHas('chats', [
        'scan_id' => null,
        'sender' => 'ai',
        'message' => 'Jawaban CareBot',
        ]);
    }
}
