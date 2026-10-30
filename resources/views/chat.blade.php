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

    <div class="h-[calc(100vh-8rem)] flex flex-col bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden relative">

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
                <!-- Bubble AI 1: Hasil Analisis Awal (Jika dari Scan) -->
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
                            @if(Auth::user()->profile_photo_path)
                                <img src="{{ asset('storage/'.Auth::user()->profile_photo_path) }}" alt="Foto profil {{ Auth::user()->name }}" class="w-8 h-8 rounded-full object-cover flex-shrink-0 mt-1">
                            @else
                                <div class="w-8 h-8 bg-blue-100 text-blue-600 rounded-full flex-shrink-0 flex items-center justify-center font-bold text-xs mt-1">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</div>
                            @endif
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
                <!-- Pesan Sambutan Jika Chat Langsung (Tanpa Scan) -->
                <div class="flex gap-3 max-w-3xl">
                    <div class="w-8 h-8 bg-[#0ea5e9] rounded-full flex-shrink-0 flex items-center justify-center text-white mt-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <div>
                        <div class="bg-white border border-gray-100 p-4 rounded-2xl rounded-tl-none shadow-sm text-sm text-gray-700 leading-relaxed">
                            Halo! Aku CareBot. Silakan ketik pertanyaan atau <b>paste gambar</b> (Ctrl+V) di sini untuk memulai percakapan.
                        </div>
                        <span class="text-[10px] text-gray-400 mt-1 block">Sistem · CareBot</span>
                    </div>
                </div>
            @endif

        </div>

        <!-- Input Area (SELALU MUNCUL) -->
        <div class="p-4 bg-white border-t border-gray-100 relative z-20">

            <!-- Preview Gambar (Untuk Upload / Paste) -->
            <div id="previewWrap" class="absolute bottom-full left-4 mb-3 hidden items-end gap-2 bg-white p-2 rounded-xl shadow-lg border border-gray-200">
                <img id="previewImg" class="h-16 w-16 object-cover rounded-lg border border-gray-100">
                <button type="button" id="previewClose" class="bg-red-50 text-red-500 rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-100 transition shadow-sm">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <form id="chatForm" class="flex items-center gap-3 bg-gray-50 border border-gray-200 p-2 rounded-2xl focus-within:border-[#0ea5e9] focus-within:ring-1 focus-within:ring-[#0ea5e9] transition">
                <label for="imageInput" class="w-10 h-10 bg-white border border-gray-200 text-gray-500 rounded-xl flex items-center justify-center cursor-pointer hover:bg-gray-100 transition shadow-sm" title="Unggah Gambar">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </label>
                <input type="file" id="imageInput" accept="image/*" hidden>

                <input type="text" id="messageInput" class="flex-1 bg-transparent border-none focus:ring-0 text-sm py-2 px-2 text-gray-700" placeholder="Tulis pesan atau paste gambar di sini..." autocomplete="off">

                <button type="submit" id="btnSend" class="w-10 h-10 bg-[#0ea5e9] text-white rounded-xl flex items-center justify-center hover:bg-[#0284c7] transition disabled:opacity-50 disabled:cursor-not-allowed">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                </button>
            </form>
            <p class="text-center text-[10px] text-gray-400 mt-3">CareBot dapat membuat kesalahan. Selalu verifikasi informasi medis dengan dokter.</p>
        </div>
    </div>

    <script>
        const form = document.getElementById('chatForm');
        const input = document.getElementById('messageInput');
        const chatArea = document.getElementById('chatArea');
        const btnSend = document.getElementById('btnSend');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        const userInitial = "{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}";
        const userAvatar = @json(Auth::user()->profile_photo_path ? asset('storage/'.Auth::user()->profile_photo_path) : null);
        const userAvatarMarkup = userAvatar
            ? `<img src="${userAvatar}" alt="Foto profil" class="w-8 h-8 rounded-full object-cover flex-shrink-0 mt-1">`
            : `<div class="w-8 h-8 bg-blue-100 text-blue-600 rounded-full flex-shrink-0 flex items-center justify-center font-bold text-xs mt-1">${userInitial}</div>`;

        // Elemen Upload/Paste
        const imageInput = document.getElementById('imageInput');
        const previewWrap = document.getElementById('previewWrap');
        const previewImg = document.getElementById('previewImg');
        const previewX = document.getElementById('previewClose');
        let selectedFile = null;

        // Fungsi Upload File via Tombol
        imageInput.addEventListener('change', e => {
            const file = e.target.files[0];
            if (!file) return;
            if (file.size > 10 * 1024 * 1024) return alert('Maksimal 10 MB');
            selectedFile = file;
            previewImg.src = URL.createObjectURL(file);
            previewWrap.style.display = 'flex';
        });

        // Fungsi Paste Gambar (CTRL+V)
        input.addEventListener('paste', function(e) {
            const items = (e.clipboardData || e.originalEvent.clipboardData).items;
            for (let index in items) {
                const item = items[index];
                if (item.kind === 'file' && item.type.startsWith('image/')) {
                    const file = item.getAsFile();
                    if (file.size > 10 * 1024 * 1024) return alert('Maksimal 10 MB');

                    selectedFile = file;
                    previewImg.src = URL.createObjectURL(file);
                    previewWrap.style.display = 'flex';
                    e.preventDefault();
                }
            }
        });

        // Hapus Preview
        previewX.addEventListener('click', () => {
            selectedFile = null;
            imageInput.value = '';
            previewWrap.style.display = 'none';
        });

        // Submit Chat
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            const text = input.value.trim();
            if (!text && !selectedFile) return;

            appendUserMessage(text, selectedFile);
            input.value = '';
            const currentFile = selectedFile;
            selectedFile = null;
            imageInput.value = '';
            previewWrap.style.display = 'none';

            btnSend.disabled = true;
            const loadingEl = appendLoading();

            const formData = new FormData();
            formData.append('message', text);
            if (currentFile) formData.append('image', currentFile);

            try {
                // Gunakan rute yang sesuai
                const url = "{{ $scan ? route('chat.send.scan', $scan->id) : route('chat.send') }}";

                const res = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                const data = await res.json();
                loadingEl.remove();

                if (res.ok) {
                    appendAIMessage(data.reply);
                } else {
                    appendAIMessage(data.reply || '⚠️ Terjadi kesalahan.');
                }
            } catch (err) {
                loadingEl.remove();
                appendAIMessage('⚠️ Koneksi internet terputus.');
                console.error(err);
            } finally {
                btnSend.disabled = false;
                input.focus();
            }
        });

        // Helper Render Pesan
        function appendUserMessage(text, file) {
            const wrap = document.createElement('div');
            wrap.className = 'flex gap-3 max-w-3xl ml-auto flex-row-reverse';
            let inner = '';
            if (file) {
                const url = URL.createObjectURL(file);
                inner += `<img src="${url}" class="max-w-[200px] rounded-xl mb-2 border-2 border-white/20">`;
            }
            if (text) inner += `<div>${escapeHtml(text)}</div>`;

            wrap.innerHTML = `
                ${userAvatarMarkup}
                <div>
                    <div class="bg-[#0ea5e9] text-white p-4 rounded-2xl rounded-tr-none shadow-sm text-sm leading-relaxed">
                        ${inner}
                    </div>
                    <span class="text-[10px] text-gray-400 mt-1 block text-right">Baru saja · Kamu</span>
                </div>`;
            chatArea.appendChild(wrap);
            chatArea.scrollTop = chatArea.scrollHeight;
        }

        function appendAIMessage(html) {
            const wrap = document.createElement('div');
            wrap.className = 'flex gap-3 max-w-3xl';
            let cleanHtml = html;
            try {
                if (typeof marked !== 'undefined') cleanHtml = marked.parse(html);
                if (typeof DOMPurify !== 'undefined') cleanHtml = DOMPurify.sanitize(cleanHtml);
            } catch (e) { cleanHtml = escapeHtml(html); }

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
    </script>
</x-app-layout>