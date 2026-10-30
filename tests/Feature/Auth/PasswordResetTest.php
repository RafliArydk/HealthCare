<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Notifications\PasswordResetCodeNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    public function test_reset_password_link_screen_can_be_rendered(): void
    {
        $response = $this->get('/forgot-password');

        $response->assertStatus(200);
    }

    public function test_reset_password_link_can_be_requested(): void
    {
        Notification::fake();

        $user = User::factory()->create();

        $this->post('/forgot-password', ['email' => $user->email]);

        Notification::assertSentTo($user, PasswordResetCodeNotification::class);
    }

    public function test_reset_password_screen_can_be_rendered(): void
    {
        Notification::fake();

        $user = User::factory()->create();

        $this->post('/forgot-password', ['email' => $user->email]);

        Notification::assertSentTo($user, PasswordResetCodeNotification::class, function ($notification) {
            $this->post('/forgot-password/verify', ['code' => $notification->code()])
                ->assertRedirect(route('password.reset.code'));

            $response = $this->get(route('password.reset.code'));

            $response->assertStatus(200);

            return true;
        });
    }

    public function test_password_can_be_reset_with_valid_token(): void
    {
        Notification::fake();

        $user = User::factory()->create();

        $this->post('/forgot-password', ['email' => $user->email]);

        Notification::assertSentTo($user, PasswordResetCodeNotification::class, function ($notification) use ($user) {
            $this->post('/forgot-password/verify', ['code' => $notification->code()])
                ->assertRedirect(route('password.reset.code'));

            $response = $this->post('/reset-password', [
                'token' => $notification->code(),
                'email' => $user->email,
                'password' => 'Password1!',
                'password_confirmation' => 'Password1!',
            ]);

            $response
                ->assertSessionHasNoErrors()
                ->assertRedirect(route('login'));

            return true;
        });
    }
}
