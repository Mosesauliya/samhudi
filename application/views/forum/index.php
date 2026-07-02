<?php
/**
 * @var array $forums
 */
?>
<section class="forum-section">
    <div class="container">
        <h1 class="forum-heading">Forum Diskusi Keluarga</h1>
        <p><a href="<?= base_url('forum/create') ?>" class="btn-forum">+ Buat Topik Baru</a></p>

        <?php if (empty($forums)): ?>
            <p>Belum ada topik diskusi. Jadilah yang pertama!</p>
        <?php else: ?>
            <?php foreach ($forums as $forum): ?>
                <div class="thread-item">
                    <a href="<?= base_url('forum/view/' . $forum->id) ?>">
                        <?= htmlspecialchars($forum->title) ?>
                    </a>
                    <div class="meta">
                        Oleh <?= htmlspecialchars($forum->author_name ?? 'Anonim') ?> · <?= $forum->created_at ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>