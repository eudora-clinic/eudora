<script src="https://cdn.socket.io/4.7.2/socket.io.min.js"></script>

<style>
    .chat-container {
        display: flex;
        height: 75vh
    }

    .chat-list {
        width: 20%;
        display: flex;
        flex-direction: column;
        padding: 10px;
        border-left: 1px solid #ccc;
        border-top: 1px solid #ccc;
        border-bottom: 1px solid #ccc;
        background-color: #fff;
        border-top-left-radius: 10px;
        border-bottom-left-radius: 10px;
    }

    .chat-search {
        padding: 10px;
        border-bottom: 1px solid #ccc;
    }

    .chat-search input {
        width: 100%;
        padding: 8px 10px;
        border: 1px solid #ccc;
        border-radius: 20px;
    }

    .chat-box-container {
        width: 80%;
        padding: 5px;
        display: flex;
        flex-direction: column;
        background-color: #fff;
        border-top: 1px solid #ccc;
        border-bottom: 1px solid #ccc;
        border-right: 1px solid #ccc;
        border-top-right-radius: 10px;
        border-bottom-right-radius: 10px;

    }

    .chat-box {
        flex: 1;
        overflow-y: auto;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 10px;
        background-color: #fff;
        /* max-height: 300px; */
    }

    .chat-items {
        flex: 1;
        overflow-y: auto;
        padding: 10px;
    }

    .chat-items::-webkit-scrollbar {
        width: 3px;
        /* Lebar scrollbar */
    }

    .chat-items::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .chat-items::-webkit-scrollbar-thumb {
        background: #bbb;
        border-radius: 10px;
    }

    .chat-items::-webkit-scrollbar-thumb:hover {
        background: #999;
    }

    .chat-box::-webkit-scrollbar {
        width: 3px;
        /* Lebar scrollbar */
    }

    .chat-box::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .chat-box::-webkit-scrollbar-thumb {
        background: #bbb;
        border-radius: 10px;
    }

    .chat-box::-webkit-scrollbar-thumb:hover {
        background: #999;
    }


    .chat-message {
        margin-bottom: 10px;
        display: flex;
        flex-direction: column;
    }

    .chat-message.you {
        align-items: flex-end;
    }

    .chat-message.them {
        align-items: flex-start;
    }

    .bubble {
        padding: 10px;
        border-radius: 10px;
        max-width: 80%;
    }

    .bubble.you {
        background-color: #d1e7dd;
        text-align: right;
    }

    .bubble.them {
        background-color: #fff3cd;
        text-align: left;
    }

    .chat-footer {
        margin-top: 15px;
        display: flex;
        gap: 10px;
    }

    .chat-footer input[type="text"] {
        flex: 1;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 20px;
    }

    .chat-footer button {
        padding: 10px 20px;
        border: none;
        border-radius: 20px;
        background-color: #0d6efd;
        color: white;
        cursor: pointer;
    }

    .chat-item {
        border-bottom: 1px solid #ccc;
        padding: 10px;
        cursor: pointer;

    }


    .username {
        font-weight: bold;
    }

    .last-message {
        color: gray;
    }

    .unread {
        color: red;
        font-size: 12px;
    }

    .chat-item:hover {
        background-color: #f2f2f2;
    }

    .chat-item.active {
        background-color: #d6eaff;
        /* warna saat aktif */
    }
</style>


<div class="chat-container">
    <div class="chat-list">
        <div class="chat-search">
            <input type="text" id="searchInput" placeholder="Search chat...">
        </div>
        <div class="chat-items" id="chat-list">
            Loading chat list...
        </div>
    </div>
    <div class="chat-box-container">
        <div class="chat-box" id="chat-box">
            <div style="padding: 10px; color: gray;">Select a chat to view messages</div>
        </div>
        <div id="floatingImagePreview" style="display: none; position: fixed; top: 0; left: 0;
    width: 100vw; height: 100vh; background: rgba(0, 0, 0, 0.7);
    display: flex; flex-direction: column; align-items: center; justify-content: center; z-index: 10000;">

            <div style="position: relative;">
                <img id="previewImage" src="" alt="Preview"
                    style="max-width: 90vw; max-height: 80vh; border-radius: 10px; box-shadow: 0 0 20px rgba(0,0,0,0.3);">
                <button id="closePreview" type="button" style="position: absolute; top: -10px; right: -10px; background: red; color: white; border: none;
            border-radius: 50%; width: 30px; height: 30px; font-size: 18px; cursor: pointer;">×</button>
            </div>

            <!-- Tombol Send -->
            <button id="sendImageBtn" style="margin-top: 20px; padding: 10px 30px; border-radius: 30px; border: none;
        background-color: #0d6efd; color: white; font-size: 16px; cursor: pointer;">
                Send
            </button>
        </div>



        <form class="chat-footer" id="message-form" style="display: none;">
            <input type="hidden" name="receiver_id" id="receiver_id">
            <input type="hidden" name="receiver_type" id="receiver_type">
            <input type="text" name="message" placeholder="Type your message..." required
                style="flex: 1; padding: 10px; border: 1px solid #ccc; border-radius: 20px;">

            <input type="hidden" name="type" id="type" value="text">


            <button type="button" id="openFilePicker"
                style="padding: 10px; border-radius: 20px; border: 1px solid #ccc; background: #f0f0f0;">
                📷
            </button>

            <input type="file" name="image" id="imageInput" accept="image/*" style="display: none;">

            <button type="submit" id="send-btn"
                style="padding: 10px 20px; border: none; border-radius: 20px; background-color: #0d6efd; color: white;">Send</button>
        </form>
    </div>
</div>

<script>
    const openFilePicker = document.getElementById('openFilePicker');
    let allowImagePreview = false;

    openFilePicker.addEventListener('click', () => {
        allowImagePreview = true; // izinkan preview hanya kalau user klik tombol 📷
        imageInput.click();
    });
</script>


<script>
    const imageInput = document.getElementById('imageInput');
    const previewOverlay = document.getElementById('floatingImagePreview');
    const previewImage = document.getElementById('previewImage');
    const closeBtn = document.getElementById('closePreview');
    const sendBtn = document.getElementById('sendImageBtn');
    const messageForm = document.getElementById('message-form');

    let fileChangedByUser = false;
    let resetByScript = false;

    previewOverlay.style.display = 'none';
    imageInput.value = '';
    previewImage.src = '';

    // Reset input file saat halaman pertama kali dibuka
    window.addEventListener('load', () => {
        resetByScript = true;
        imageInput.value = '';
        setTimeout(() => resetByScript = false, 500); // cegah trigger selama 500ms
    });

    // Tandai saat user mengklik file input
    imageInput.addEventListener('click', function () {
        fileChangedByUser = true;
    });

    imageInput.addEventListener('change', function (event) {
        const file = this.files[0];

        console.log(file);


        // ❌ Tidak ada file dipilih
        if (!file) {
            previewOverlay.style.display = 'none';
            previewImage.src = '';
            return;
        }

        // ✅ Validasi hanya gambar
        if (!file.type.startsWith('image/')) {
            alert('Please select a valid image file.');
            previewOverlay.style.display = 'none';
            previewImage.src = '';
            return;
        }

        // ✅ Tampilkan preview
        previewImage.src = URL.createObjectURL(file);
        previewOverlay.style.display = 'flex';
        sendBtn.style.display = 'flex';
    });



    // Tombol batal preview
    closeBtn.addEventListener('click', function () {
        previewOverlay.style.display = 'none';
        imageInput.value = '';
        previewImage.src = '';
    });

    // Klik di luar area gambar = batal
    previewOverlay.addEventListener('click', function (e) {
        if (e.target === previewOverlay) {
            previewOverlay.style.display = 'none';
            imageInput.value = '';
            previewImage.src = '';
        }
    });

    // sendBtn.addEventListener('click', function () {
    //     previewOverlay.style.display = 'none';
    //     messageForm.submit();
    // });

    sendBtn.addEventListener('click', function () {
        // Cek apakah ada file gambar yang dipilih
        previewOverlay.style.display = 'none';
        // messageForm.submit();
        if (!imageInput.files || imageInput.files.length === 0) {
            alert('No image selected');
            return;
        }

        // Submit form secara manual (dengan AJAX)
        sendImageMessage();
    });

    function sanitizeFileName(filename) {
        // Pisahkan nama dan ekstensi
        const lastDot = filename.lastIndexOf('.');
        let name = lastDot !== -1 ? filename.substring(0, lastDot) : filename;
        const ext = lastDot !== -1 ? filename.substring(lastDot) : '';

        // Lowercase dan ganti spasi/karakter aneh dengan underscore
        name = name.toLowerCase().replace(/[^a-z0-9]+/g, '_');

        // Batasi panjang nama file (misal max 30 karakter)
        if (name.length > 30) {
            name = name.substring(0, 30);
        }

        // Tambahkan timestamp untuk unik
        const timestamp = Date.now();

        return `${name}_${timestamp}${ext}`;
    }



    function sendImageMessage() {
        const form = document.getElementById('message-form');
        const receiverId = document.getElementById('receiver_id').value;
        const receiverType = document.getElementById('receiver_type').value;
        const file = imageInput.files[0];

        if (!receiverId || !receiverType) {
            alert('Please select a chat first');
            return;
        }

        const originalName = file.name;
        const sanitizedFileName = sanitizeFileName(originalName);
        const newFile = new File([file], sanitizedFileName, { type: file.type });


        // Siapkan FormData agar bisa kirim file
        const formData = new FormData();
        formData.append('receiver_id', receiverId);
        formData.append('receiver_type', receiverType);
        formData.append('message', ''); // kosongkan pesan text kalau cuma gambar
        formData.append('type', 'image');
        formData.append('image', newFile); // beri tanda bahwa ini gambar

        console.log('FormData contents:');
        for (const pair of formData.entries()) {
            if (pair[1] instanceof File) {
                console.log(pair[0] + ':', pair[1].name, pair[1].type, pair[1].size + ' bytes');
            } else {
                console.log(pair[0] + ':', pair[1]);
            }
        }



        $.ajax({
            url: "<?= base_url('sendMessagesImagesByEmployee') ?>",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function (data) {
                console.log(data);

                const previewOverlay = document.getElementById('floatingImagePreview');
                const previewImage = document.getElementById('previewImage');
                const sendBtn = document.getElementById('sendImageBtn');

                if (data.status === 'success') {
                    const chatBox = document.getElementById('chat-box');
                    const div = document.createElement('div');
                    div.className = 'chat-message you';
                    div.innerHTML = `
                            <div class="bubble you" style="cursor: pointer;">
                                <img src="${URL.createObjectURL(file)}" style="max-width: 150px; border-radius: 10px;">
                            </div>
                            <div style="font-size: 10px; color: gray;">Just now</div>
                        `;

                    const img = div.querySelector('img');
                    img.addEventListener('click', () => {
                        previewImage.src = img.src;
                        previewOverlay.style.display = 'flex';
                        // Sembunyikan tombol send saat preview dari chat sudah terkirim
                        sendBtn.style.display = 'none';
                    });

                    chatBox.appendChild(div);

                    // Scroll ke bawah
                    chatBox.scrollTop = chatBox.scrollHeight;

                    // Tutup preview input file
                    previewOverlay.style.display = 'none';
                    imageInput.value = '';
                    previewImage.src = '';
                } else {
                    alert('Failed to send image message');
                }

            },
            error: function (xhr, status, error) {
                console.error("Error:", error);
                alert("Failed to send image message. Please try again.");
            }
        });
    }

</script>



<script>
    const userid = "<?= $userId ?>";

    let allChats = [];
    let activeReceiverId = null;
    let activeReceiverType = null;

    const BASE_URL = "<?= base_url() ?>";


    async function loadChatList() {
        try {
            const response = await fetch(`${BASE_URL}/getChatList?user_id=${userid}&user_type=employee`);
            const res = await response.json();
            if (res.status === 'success') {
                allChats = res.data;
                renderChatList(allChats);
            } else {
                document.getElementById('chat-list').innerHTML = 'Error fetching chat list';
            }
        } catch (error) {
            console.error("Failed to load chat list", error);
        }
    }

    function renderChatList(chats) {
        const container = document.getElementById('chat-list');
        container.innerHTML = '';

        if (chats.length === 0) {
            container.innerHTML = '<div style="padding: 10px;">No chats found.</div>';
            return;
        }

        chats.forEach(item => {
            console.log(item);
            const el = document.createElement('div');
            el.className = 'chat-item';
            el.innerHTML = `
                    <div class="username">${item.username || '(Unknown)'}</div>
                    <div class="last-message">${item.type === 'image' ? 'Image' : (item.message || '')}</div>
                    ${item.unread_count > 0 ? `<div class="unread">Unread: ${item.unread_count}</div>` : ''}
                `;
            el.onclick = () => {
                document.querySelectorAll('.chat-item').forEach(item => {
                    item.classList.remove('active');
                });
                el.classList.add('active');

                document.getElementById('message-form').style.display = 'flex';

                document.getElementById('receiver_id').value = item.chat_user_id;
                document.getElementById('receiver_type').value = item.chat_user_type;

                activeReceiverId = item.chat_user_id;
                activeReceiverType = item.chat_user_type;

                loadChatDetail(activeReceiverId, activeReceiverType);
            };

            container.appendChild(el);
        });
    }

    function loadChatDetail(receiver_id, receiver_type) {
        fetch(`${BASE_URL}/detailConsultationChat?receiver_id=${receiver_id}&receiver_type=${receiver_type}&sender_id=${userid}`)
            .then(response => response.json())
            .then(res => {
                const chatBox = document.getElementById('chat-box');
                chatBox.innerHTML = '';

                if (res.status === 'success') {
                    res.data.messages.forEach(msg => {
                        const isUser = msg.sender_id == userid && msg.sender_type == 'employee';
                        const align = isUser ? 'you' : 'them';
                        const bubble = isUser ? 'you' : 'them';

                        const div = document.createElement('div');
                        div.className = `chat-message ${align}`;

                        if (msg.type === 'image' && msg.message) {
                            div.innerHTML = `
                            <div class="bubble ${bubble}" style="cursor: pointer;">
                                <img src="${BASE_URL}/${msg.message}" alt="Image message" style="max-width: 200px; border-radius: 10px;" />
                            </div>
                            <div style="font-size: 10px; color: gray;">${msg.created_at}</div>
                        `;
                            const img = div.querySelector('img');
                            img.addEventListener('click', () => {
                                const previewOverlay = document.getElementById('floatingImagePreview');
                                const previewImage = document.getElementById('previewImage');
                                const sendBtn = document.getElementById('sendImageBtn');

                                previewImage.src = img.src;
                                previewOverlay.style.display = 'flex';
                                sendBtn.style.display = 'none';
                            });
                        } else {
                            div.innerHTML = `
                            <div class="bubble ${bubble}">${msg.message}</div>
                            <div style="font-size: 10px; color: gray;">${msg.created_at}</div>
                        `;
                        }

                        chatBox.appendChild(div);
                    });
                    chatBox.scrollTop = chatBox.scrollHeight;
                    loadChatList()
                } else {
                    chatBox.innerHTML = '<div style="padding: 10px;">Error loading messages</div>';
                }
            });
    }



    function setupWebSocket() {
        const socket = io("https://sys.eudoraclinic.com:3001", {
            transports: ["websocket", "polling"]
        });


        socket.on("connect", () => {
            console.log("✅ Connected to WebSocket Server");
            socket.emit("joinRoom", `employee_${userid}`);
        });

        socket.on("newMessage", (data) => {
            console.log("📥 Message received:", data);
            if (data.receiver_id == userid && data.receiver_type == "employee") {
                loadChatList();
                if (activeReceiverId && activeReceiverType) {
                    loadChatDetail(activeReceiverId, activeReceiverType);
                }
            }
        });

        socket.on("disconnect", () => {
            console.log("🔴 Disconnected from WebSocket Server");
        });
    }

    function init() {
        loadChatList();
        setupWebSocket();

        // // Event search input
        document.getElementById('searchInput').addEventListener('input', function () {
            const keyword = this.value.toLowerCase();
            const filtered = allChats.filter(c => (c.username || '').toLowerCase().includes(keyword));
            renderChatList(filtered);
        });
    }

    // Jalankan init setelah DOM siap
    document.addEventListener('DOMContentLoaded', init);

</script>

<script>
    window.onload = function () {
        const chatBox = document.getElementById("chat-box");
        chatBox.scrollTop = chatBox.scrollHeight;
    };
</script>

<script>
    document.getElementById('message-form').addEventListener('submit', function (e) {
        e.preventDefault();
        const formData = $(this).serialize();

        const sendBtn = document.getElementById('send-btn');

        // Ubah tombol jadi loading
        sendBtn.disabled = true;
        sendBtn.innerHTML = 'Sending...';
        setTimeout(() => {
            $.ajax({
                url: "<?= base_url('sendMessagesEmployee') ?>",
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function (data) {
                    sendBtn.disabled = false;
                    sendBtn.innerHTML = 'Send';
                    if (data.status === 'success') {
                        const chatBox = document.getElementById('chat-box');
                        const div = document.createElement('div');
                        div.className = 'chat-message you';
                        div.innerHTML = `
                    <div class="bubble you">${$('input[name="message"]').val()}</div>
                    <div style="font-size: 10px; color: gray;">Just now</div>
                `;
                        chatBox.appendChild(div);
                        $('input[name="message"]').val('');
                        chatBox.scrollTop = chatBox.scrollHeight;
                    }
                },
                error: function (xhr, status, error) {
                    sendBtn.disabled = false;
                    sendBtn.innerHTML = 'Send';
                    console.error("Error:", error);
                    alert("Failed to send message. Please try again.");
                }
            });
        }, 0);
    });
</script>