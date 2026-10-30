<?php

namespace App\Http\Controllers;

use App\Models\Scan;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class ChatPageController extends Controller
{
    public function __invoke(?Scan $scan = null): View
    {
        if ($scan !== null && $scan->user_id !== Auth::id()) {
            abort(404);
        }

        return view('chat', ['scan' => $scan]);
    }
}
