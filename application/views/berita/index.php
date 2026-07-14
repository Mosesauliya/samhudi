<?php if (!empty($news_items)): ?>
<section class="py-5 berita-section" style="min-height: 100vh;">
    <div class="container">

        <div class="text-center mb-5 pt-5">
            <h2 class="berita-heading">
                Berita
            </h2>
            <p class="berita-subheading">
                Informasi Terkait Civitas H.M Samhudi
            </p>
        </div>

        <div class="row g-3">
            <?php foreach ($news_items as $news): ?>
            <div class="col-lg-4 col-md-6">
                <div class="news-wrapper h-100">
                    <img src="<?php echo !empty($news['thumbnail']) && file_exists('./' . $news['thumbnail']) ? base_url($news['thumbnail']) : base_url('assets/images/berita/berita1.png'); ?>" class="img-fluid w-100 news-img-grid" style="object-fit: cover; height: 100%; min-height: 250px;">
                    <div class="news-overlay"></div>
                    <div class="news-content-grid">
                        <h6 class="news-title-grid">
                            <?php echo htmlspecialchars($news['title']); ?>
                        </h6>
                        <?php if (!empty($news['external_link'])): ?>
                            <a href="<?php echo htmlspecialchars($news['external_link']); ?>" target="_blank" style="text-decoration:none;">
                                <small class="news-link-grid text-white">BACA SELENGKAPNYA</small>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>
<?php else: ?>
<section class="py-5 berita-section" style="min-height: 100vh;">
    <div class="container">
        <div class="text-center mb-5 pt-5">
            <h2 class="berita-heading">Berita</h2>
            <p class="berita-subheading">Belum ada berita tersedia.</p>
        </div>
    </div>
</section>
<?php endif; ?>
