<section class="forum-section">
    <div class="container">
        <h1 class="forum-heading">Buat Topik Diskusi Baru</h1>
        <a href="<?= base_url('forum') ?>">&larr; Kembali ke Forum</a>

        <?= form_open('forum/create') ?>

            <label>Judul Topik</label>
            <?= form_input('title', set_value('title')) ?>
            <?= form_error('title', '<div class="error">', '</div>') ?>

            <label>Isi Diskusi</label>
            <?= form_textarea(['name' => 'content', 'rows' => 6, 'value' => set_value('content')]) ?>
            <?= form_error('content', '<div class="error">', '</div>') ?>

            <button type="submit" class="btn-forum">Posting Topik</button>

        <?= form_close() ?>
    </div>
</section>