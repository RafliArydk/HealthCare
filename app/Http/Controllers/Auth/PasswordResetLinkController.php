<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\PasswordResetCodeNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $email = Str::lower($request->string('email')->toString());
        $user = User::where('email', $email)->first();

        if ($user) {
            $code = (string) random_int(100000, 999999);

            DB::table(config('auth.passwords.users.table', 'password_reset_tokens'))
                ->where('email', $email)
                ->delete();

            DB::table(config('auth.passwords.users.table', 'password_reset_tokens'))
                ->insert([
                    'email' => $email,
                    'token' => Hash::make($code),
                    'created_at' => now(),
                ]);

            $user->notify(new PasswordResetCodeNotification($code));
        }

        session()->put('password_reset_email', $email);

        return redirect()->route('password.verify');
    }

    public function verification(Request $request): View|RedirectResponse
    {
        $email = session('password_reset_email');

        if (! $email) {
            return redirect()->route('password.request');
        }

        return view('auth.verify-reset-code', ['email' => $email]);
    }

    public function verify(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'code' => ['required', 'digits:6'],
        ]);

        $email = session('password_reset_email');
        $record = $email
            ? DB::table(config('auth.passwords.users.table', 'password_reset_tokens'))
                ->where('email', $email)
                ->first()
            : null;

        if (! $record || ! Hash::check($validated['code'], $record->token)) {
            throw ValidationException::withMessages([
                'code' => 'Kode verifikasi tidak valid atau sudah kedaluwarsa.',
            ]);
        }

        session()->put([
            'password_reset_verified' => true,
            'password_reset_token' => $validated['code'],
        ]);

        return redirect()->route('password.reset.code');
    }
}
