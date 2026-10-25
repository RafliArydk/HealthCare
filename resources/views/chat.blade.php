@extends('layouts.app')

@section('content')
<div class="hc-container">

    <div class="hc-chat" id="chatArea">
        <div class="hc-msg hc-msg-ai">
            <div class="hc-avatar"><i class="bi bi-robot"></i></div>
            <div class="hc-bubble">
                <strong>Halo! 👋 Saya HealthCare.</strong><br>
                Kirim <b>foto luka</b> atau <b>kemasan obat</b>, dan saya akan membantu memberikan informasi awal medis.
            </div>
        </div>
    </div>

    <div class="hc-inputbar-wrap">
        <div class="hc-preview-wrap" id="previewWrap">
            <img id="previewImg" class="hc-preview-img" alt="preview">
            <button type="button" class="hc-preview-close" id="previewClose">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>


        <form id="chatForm" class="hc-inputbar" enctype="multipart/form-data">
            <label for="imageInput" class="hc-btn-icon" title="Unggah gambar">
                <i class="bi bi-image"></i>
            </label>
            <input type="file" id="imageInput" accept="image/*" hidden>

            <input type="text" id="textInput" class="hc-textinput" placeholder="Tulis pesan atau unggah gambar..." autocomplete="off">

            <button type="submit" class="hc-btn-send" id="btnSend" title="Kirim">
                <i class="bi bi-send-fill"></i>
            </button>
        </form>
    </div>

</div>
@endsection

@push('scripts')
<script>
    const form       = document.getElementById('chatForm');
    const imageInput = document.getElementById('imageInput');
    const textInput  = document.getElementById('textInput');
    const chatArea   = document.getElementById('chatArea');
    const previewWrap= document.getElementById('previewWrap');
    const previewImg = document.getElementById('previewImg');
    const previewX   = document.getElementById('previewClose');
    const btnSend    = document.getElementById('btnSend');

    let selectedFile = null;
    let isLoading    = false;

        // FITUR PASTE GAMBAR (CTRL+V)
    textInput.addEventListener('paste', function(e) {
        const items = (e.clipboardData || e.originalEvent.clipboardData).items;
        for (let index in items) {
            const item = items[index];
            if (item.kind === 'file' && item.type.startsWith('image/')) {
                const file = item.getAsFile();

                // Cek ukuran maksimal 4 MB
                if (file.size > 4 * 1024 * 1024) {
                    alert('Maksimal ukuran gambar adalah 4 MB');
                    return;
                }

                // Set gambar yang di-paste
                selectedFile = file;
                previewImg.src = URL.createObjectURL(file);
                previewWrap.style.display = 'block';

                // Cegah browser nge-paste path file, kita cuma mau gambarnya aja
                e.preventDefault();
            }
        }
    });

    imageInput.addEventListener('change', e => {
        const file = e.target.files[0];
        if (!file) return;

        if (file.size > 4 * 1024 * 1024) {
            alert('Maksimal ukuran gambar adalah 4 MB');
            imageInput.value = '';
            return;
        }

        selectedFile = file;
        previewImg.src = URL.createObjectURL(file);
        previewWrap.style.display = 'block';
    });

    previewX.addEventListener('click', () => {
        selectedFile = null;
        imageInput.value = '';
        previewWrap.style.display = 'none';
    });

    form.addEventListener('submit', async e => {
        e.preventDefault();
        if (isLoading) return;

        const text = textInput.value.trim();
        if (!text && !selectedFile) return;

        appendUserMessage(text, selectedFile);
        isLoading = true;
        btnSend.disabled = true;

        const loadingEl = appendLoading();

        const fd = new FormData();
        fd.append('text', text);
        if (selectedFile) fd.append('image', selectedFile);

        textInput.value = '';
        selectedFile = null;
        imageInput.value = '';
        previewWrap.style.display = 'none';

        try {
            const res = await fetch("{{ route('chat.send') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: fd
            });

            const data = await res.json();
            loadingEl.remove();

            // Jika server ngasih status error (500, 503, dll)
            if (!res.ok) {
                appendErrorMessage(data.reply || 'Terjadi kesalahan pada server.');
            } else {
                appendAIMessage(data.reply);
            }

        } catch (err) {
            // Jika internet beneran mati (fetch gagal total)
            loadingEl.remove();
            appendErrorMessage('⚠️ Koneksi internet terputus. Silakan periksa jaringan Anda dan coba lagi.');
        } finally {
            isLoading = false;
            btnSend.disabled = false;
        }

    function appendUserMessage(text, file) {
        const wrap = document.createElement('div');
        wrap.className = 'hc-msg hc-msg-user';
        let inner = '';

        if (file) {
            const url = URL.createObjectURL(file);
            inner += `<img src="${url}" class="hc-chat-img" alt="gambar">`;
        }
        if (text) {
            inner += `<div>${escapeHtml(text)}</div>`;
        }

        wrap.innerHTML = `<div class="hc-bubble">${inner}</div>`;
        chatArea.appendChild(wrap);
        scrollBottom();
    }

    function appendAIMessage(html) {
        const wrap = document.createElement('div');
        wrap.className = 'hc-msg hc-msg-ai';

        // SANITASI XSS: Bersihkan HTML sebelum di-render
        const cleanHtml = DOMPurify.sanitize(marked.parse(html));

        const disclaimer = `
            <div class="hc-disclaimer">
                <i class="bi bi-exclamation-triangle-fill"></i>
                Peringatan: Informasi ini dihasilkan oleh AI (HealthCare) dan bukan diagnosis medis. Segera konsultasikan ke dokter.
            </div>`;

        wrap.innerHTML = `
            <div class="hc-avatar"><i class="bi bi-robot"></i></div>
            <div class="hc-bubble">
                ${cleanHtml}
                ${disclaimer}
            </div>`;

        chatArea.appendChild(wrap);
        scrollBottom();
    }

    function appendErrorMessage(msg) {
        const wrap = document.createElement('div');
        wrap.className = 'hc-msg hc-msg-ai'; // Pakai style AI
        wrap.innerHTML = `
            <div class="hc-avatar" style="background: #ef4444;"><i class="bi bi-exclamation-triangle-fill"></i></div>
            <div class="hc-bubble" style="border-color: #ef4444; background: #fef2f2; color: #b91c1c;">
                <strong>Sistem Error</strong><br>
                ${escapeHtml(msg)}
            </div>`;
        chatArea.appendChild(wrap);
        scrollBottom();
    }

    function appendLoading() {
        const wrap = document.createElement('div');
        wrap.className = 'hc-msg hc-msg-ai';
        wrap.innerHTML = `
            <div class="hc-avatar"><i class="bi bi-robot"></i></div>
            <div class="hc-bubble hc-typing">
                <span></span><span></span><span></span>
            </div>`;
        chatArea.appendChild(wrap);
        scrollBottom();
        return wrap;
    }

    function scrollBottom() {
        chatArea.scrollTop = chatArea.scrollHeight;
    }

    function escapeHtml(s) {
        const d = document.createElement('div');
        d.textContent = s;
        return d.innerHTML;
    }
</script>
@endpush