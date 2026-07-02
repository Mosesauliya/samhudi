<?php
/**
 * @var object $forum
 * @var array $comments
 */
?>
<section class="forum-section">
    <div class="container">
        <a href="<?= base_url('forum') ?>">&larr; Kembali ke Forum</a>

        <div class="thread-box">
            <h2><?= htmlspecialchars($forum->title) ?></h2>
            <p><?= nl2br(htmlspecialchars($forum->content)) ?></p>
            <div class="meta">Oleh <?= htmlspecialchars($forum->author_name ?? 'Anonim') ?> · <?= $forum->created_at ?></div>
        </div>

        <h3>Komentar (<?= count($comments) ?>)</h3>

        <?php if (empty($comments)): ?>
            <p>Belum ada komentar.</p>
        <?php else: ?>
            <?php foreach ($comments as $comment): ?>
                <div class="comment-box">
                    <p><?= nl2br(htmlspecialchars($comment->comment)) ?></p>
                    <div class="meta">Oleh <?= htmlspecialchars($comment->author_name ?? 'Anonim') ?> · <?= $comment->created_at ?></div>
                    <span class="reply-link" onclick="toggleReply(<?= $comment->id ?>)">Balas</span>

                    <div class="reply-form" id="reply-form-<?= $comment->id ?>">
                        <?= form_open('forum/comment/' . $forum->id) ?>
                            <input type="hidden" name="parent_id" value="<?= $comment->id ?>">
                            <textarea name="comment" rows="3" placeholder="Tulis balasan..."></textarea>
                            <button type="submit" class="btn-forum">Kirim Balasan</button>
                        <?= form_close() ?>
                    </div>

                    <?php foreach ($comment->replies as $reply): ?>
                        <div class="reply-box">
                            <p><?= nl2br(htmlspecialchars($reply->comment)) ?></p>
                            <div class="meta">Oleh <?= htmlspecialchars($reply->author_name ?? 'Anonim') ?> · <?= $reply->created_at ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <h3>Tulis Komentar</h3>
        <?= form_open('forum/comment/' . $forum->id) ?>
            <?= form_error('comment', '<div class="error">', '</div>') ?>
            <textarea name="comment" rows="4" placeholder="Tulis komentar..."></textarea>
            <button type="submit" class="btn-forum">Kirim Komentar</button>
        <?= form_close() ?>
    </div>
</section>

<script>
    function toggleReply(id) {
        var form = document.getElementById('reply-form-' + id);
        form.style.display = (form.style.display === 'block') ? 'none' : 'block';
    }
</script>