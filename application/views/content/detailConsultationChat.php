<div
    style="margin: 20px auto; padding: 10px; border: 1px solid #ccc; border-radius: 10px; background-color: #f9f9f9;">
    <div id="chat-box" style="max-height: 300px; overflow-y: auto; padding: 10px;">
        <?php foreach ($data as $msg): ?>
            <?php
            $isUser = ($msg->sender_id == 10 && $msg->sender_type == 'employee');
            $bubbleStyle = $isUser
                ? 'background-color: #d1e7dd; text-align: right; align-self: flex-end;'
                : 'background-color: #fff3cd; text-align: left; align-self: flex-start;';
            ?>
            <div
                style="margin-bottom: 10px; display: flex; flex-direction: column; <?= $isUser ? 'align-items: flex-end;' : 'align-items: flex-start;' ?>">
                <div style="font-size: 14px;padding: 10px; border-radius: 10px; <?= $bubbleStyle ?>">
                     <?= htmlspecialchars($msg->message) ?>
                </div>
                <div style="font-size: 10px; color: gray;"><?= $msg->created_at ?></div>
            </div>
        <?php endforeach; ?>
    </div>

    <form action="<?= base_url('sendMessage') ?>" method="POST" style="margin-top: 15px; display: flex; gap: 10px;">
        <input type="hidden" name="consultation_id" value="<?= $consultation_id ?? '' ?>">
        <input type="text" name="message" placeholder="Type your message..." required
            style="flex: 1; padding: 10px; border: 1px solid #ccc; border-radius: 20px;">
        <button type="submit"
            style="padding: 10px 20px; border: none; border-radius: 20px; background-color: #0d6efd; color: white;">Send</button>
    </form>
</div>

<script>
    window.onload = function () {
        var chatBox = document.getElementById("chat-box");
        chatBox.scrollTop = chatBox.scrollHeight;
    };
</script>