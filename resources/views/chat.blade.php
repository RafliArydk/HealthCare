<x-app-layout>
    <!-- CDN Markdown Parser & DOMPurify -->
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/dompurify@3.0.9/dist/purify.min.js"></script>

    <style>
        .prose ul { list-style-type: disc; padding-left: 1.5rem; margin-bottom: 1rem; }
        .prose ol { list-style-type: decimal; padding-left: 1.5rem; margin-bottom: 1rem; }
        .prose strong { font-weight: 700; color: #0f172a; }
        .prose p { margin-bottom: 0.75rem; }
        .prose h3, .prose h4 { font-weight: bold; margin-top: 1rem; margin-bottom: 0.5rem; color: #0ea5e9; }
    </style>

    <div class="h-[calc(100vh-8rem)] flex flex-col bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">

        <!-- Header Chat -->
        <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-white z-10">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-[#0ea5e9] rounded-full flex items-center justify-center text-white shadow-md">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900">CareBot AI</h2>
                    <div class="flex items-center gap-1.5 mt-0.5">
                        <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                        <span class="text-xs text-gray-500 font-medium">Layanan Tanya Jawab</span>
                    </div>
                </div>
            </div>
            <a href="{{ route('scan.index') }}" class="px-4 py-2 text-sm font-semibold text-gray-600 border border-gray-200 rounded-xl hover:bg-gray-50 transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Scan Baru
            </a>
        </div>

        <!-- Area Chat -->
        <div class="flex-1 overflow-y-auto p-6 space-y-6 bg-gray-50/50" id="chatArea">

            @if($scan)
                <!-- Bubble AI 1: Hasil Analisis Awal -->
                <div class="flex gap-3 max-w-3xl">
                    <div class="w-8 h-8 bg-[#0ea5e9] rounded-full flex-shrink-0 flex items-center justify-center text-white mt-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <div class="w-full">
                        <div class="bg-white border border-gray-100 p-5 rounded-2xl rounded-tl-none shadow-sm text-sm text-gray-700 leading-relaxed text-left">
                            <img src="{{ asset('storage/' . $scan->image_path) }}" class="w-full max-h-48 object-contain bg-gray-50 rounded-xl mb-4 border border-gray-100">

                            <div class="prose prose-sm max-w-none">
                                {!! Str::markdown($scan->initial_analysis) !!}
                            </div>

                            <p class="text-[10px] text-orange-500 mt-4 border-t border-gray-100 pt-2 font-medium">
                                <i class="bi bi-exclamation-triangle-fill mr-1"></i>
                                Peringatan: Informasi ini dihasilkan oleh AI dan bukan diagnosis medis.
                            </p>
                        </div>
                        <span class="text-[10px] text-gray-400 mt-1 block">Sistem · Hasil Scan</span>
                    </div>
                </div>

                <!-- Render Riwayat Chat Sebelumnya -->
                @foreach($scan->chats as $chat)
                    @if($chat->sender == 'user')
                        <div class="flex gap-3 max-w-3xl ml-auto flex-row-reverse">
                            <div class="w-8 h-8 bg-blue-100 text-blue-600 rounded-full flex-shrink-0 flex items-center justify-center font-bold text-xs mt-1">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</div>
                            <div>
                                <div class="bg-[#0ea5e9] text-white p-4 rounded-2xl rounded-tr-none shadow-sm text-sm leading-relaxed">
                                    {{ $chat->message }}
                                </div>
                                <span class="text-[10px] text-gray-400 mt-1 block text-right">{{ $chat->created_at->format('H:i') }} · Kamu</span>
                            </div>
                        </div>
                    @else
                        <div class="flex gap-3 max-w-3xl">
                            <div class="w-8 h-8 bg-[#0ea5e9] rounded-full flex-shrink-0 flex items-center justify-center text-white mt-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            </div>
                            <div>
                                <div class="bg-white border border-gray-100 p-4 rounded-2xl rounded-tl-none shadow-sm text-sm text-gray-700 leading-relaxed prose prose-sm max-w-none">
                                    {!! Str::markdown($chat->message) !!}
                                </div>
                                <span class="text-[10px] text-gray-400 mt-1 block">{{ $chat->created_at->format('H:i') }} · CareBot</span>
                            </div>
                        </div>
                    @endif
                @endforeach
            @else
                <!-- Tampilan jika tidak ada scan -->
                <div class="flex flex-col items-center justify-center h-full text-center">
                    <div class="w-16 h-16 bg-blue-50 text-[#0ea5e9] rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800">Belum ada riwayat scan</h3>
                    <p class="text-sm text-gray-500 mb-6">Silakan lakukan scan terlebih dahulu untuk mulai bertanya.</p>
                    <a href="{{ route('scan.index') }}" class="px-6 py-2.5 bg-[#0ea5e9] text-white rounded-xl font-bold">Mulai Scan</a>
                </div>
            @endif

        </div>

        <!-- Input Area -->
        @if($scan)
        <div class="p-4 bg-white border-t border-gray-100">
            <form id="chatForm" class="flex items-center gap-3 bg-gray-50 border border-gray-200 p-2 rounded-2xl focus-within:border-[#0ea5e9] focus-within:ring-1 focus-within:ring-[#0ea5e9] transition">
                <input type="text" id="messageInput" class="flex-1 bg-transparent border-none focus:ring-0 text-sm py-2 px-2 text-gray-700" placeholder="Tanya lanjutan tentang hasil scan ini..." autocomplete="off">
                <button type="submit" id="btnSend" class="w-10 h-10 bg-[#0ea5e9] text-white rounded-xl flex items-center justify-center hover:bg-[#0284c7] transition disabled:opacity-50 disabled:cursor-not-allowed">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                </button>
            </form>
            <p class="text-center text-[10px] text-gray-400 mt-3">CareBot dapat membuat kesalahan. Selalu verifikasi informasi medis dengan dokter.</p>
        </div>
        @endif
    </div>

    <script>
        @if($scan)
        const form = document.getElementById('chatForm');
        const input = document.getElementById('messageInput');
        const chatArea = document.getElementById('chatArea');
        const btnSend = document.getElementById('btnSend');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        const userInitial = "{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}";

        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            const text = input.value.trim();
            if (!text) return;

            appendUserMessage(text);
            input.value = '';
            btnSend.disabled = true;

            const loadingEl = appendLoading();

            try {
                const res = await fetch("{{ route('chat.send', $scan->id) }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ message: text })
                });

                const data = await res.json();
                loadingEl.remove();

                if (res.ok) {
                    appendAIMessage(data.reply);
                } else {
                    appendAIMessage('⚠️ Maaf, terjadi kesalahan pada server: ' + (data.message || 'Unknown Error'));
                }
            } catch (err) {
                loadingEl.remove();
                appendAIMessage('⚠️ Koneksi internet terputus atau error sistem.');
                console.error(err);
            } finally {
                btnSend.disabled = false;
                input.focus();
            }
        });

        function appendUserMessage(text) {
            const wrap = document.createElement('div');
            wrap.className = 'flex gap-3 max-w-3xl ml-auto flex-row-reverse';
            wrap.innerHTML = `
                <div class="w-8 h-8 bg-blue-100 text-blue-600 rounded-full flex-shrink-0 flex items-center justify-center font-bold text-xs mt-1">${userInitial}</div>
                <div>
                    <div class="bg-[#0ea5e9] text-white p-4 rounded-2xl rounded-tr-none shadow-sm text-sm leading-relaxed">
                        ${escapeHtml(text)}
                    </div>
                    <span class="text-[10px] text-gray-400 mt-1 block text-right">Baru saja · Kamu</span>
                </div>`;
            chatArea.appendChild(wrap);
            chatArea.scrollTop = chatArea.scrollHeight;
        }

        function appendAIMessage(html) {
            const wrap = document.createElement('div');
            wrap.className = 'flex gap-3 max-w-3xl';

            // FALLBACK AMAN: Kalau marked/dompurify gagal load, tampilkan teks biasa
            let cleanHtml = html;
            try {
                if (typeof marked !== 'undefined') cleanHtml = marked.parse(html);
                if (typeof DOMPurify !== 'undefined') cleanHtml = DOMPurify.sanitize(cleanHtml);
            } catch (e) {
                console.error("Gagal parse Markdown", e);
                cleanHtml = escapeHtml(html); // Fallback ke teks biasa
            }

            wrap.innerHTML = `
                <div class="w-8 h-8 bg-[#0ea5e9] rounded-full flex-shrink-0 flex items-center justify-center text-white mt-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <div>
                    <div class="bg-white border border-gray-100 p-4 rounded-2xl rounded-tl-none shadow-sm text-sm text-gray-700 leading-relaxed prose prose-sm max-w-none text-left">
                        ${cleanHtml}
                    </div>
                    <span class="text-[10px] text-gray-400 mt-1 block">Baru saja · CareBot</span>
                </div>`;
            chatArea.appendChild(wrap);
            chatArea.scrollTop = chatArea.scrollHeight;
        }

        function appendLoading() {
            const wrap = document.createElement('div');
            wrap.className = 'flex gap-3 max-w-3xl';
            wrap.innerHTML = `
                <div class="w-8 h-8 bg-[#0ea5e9] rounded-full flex-shrink-0 flex items-center justify-center text-white mt-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <div>
                    <div class="bg-white border border-gray-100 p-4 rounded-2xl rounded-tl-none shadow-sm flex gap-1.5 items-center h-[52px]">
                        <div class="w-2 h-2 bg-gray-300 rounded-full animate-bounce" style="animation-delay: 0ms"></div>
                        <div class="w-2 h-2 bg-gray-300 rounded-full animate-bounce" style="animation-delay: 150ms"></div>
                        <div class="w-2 h-2 bg-gray-300 rounded-full animate-bounce" style="animation-delay: 300ms"></div>
                    </div>
                </div>`;
            chatArea.appendChild(wrap);
            chatArea.scrollTop = chatArea.scrollHeight;
            return wrap;
        }

        function escapeHtml(s) {
            const d = document.createElement('div');
            d.textContent = s;
            return d.innerHTML;
        }
        @endif
    </script>
</x-app-layout>s