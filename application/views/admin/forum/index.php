<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Forum Diskusi | Admin Panel</title>
    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        teal: {
                            950: '#15201E',
                            900: '#1D2A27',
                            800: '#273834',
                            700: '#324742',
                            600: '#435E59',
                            500: '#5F7F7A',
                            400: '#8DAAA4',
                        },
                        brand: {
                            dark: '#374D49',
                            medium: '#4D6B67',
                            light: '#E3E3E3',
                            red: '#E14343',
                        }
                    },
                    fontFamily: {
                        display: ['"Plus Jakarta Sans"', 'sans-serif'],
                        body: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        * { font-family: 'Inter', sans-serif; }
        .font-display { font-family: 'Plus Jakarta Sans', sans-serif; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #15201E; }
        ::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.1); border-radius: 999px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(255, 255, 255, 0.2); }
    </style>
</head>
<body class="bg-teal-950 text-white font-body min-h-screen flex">

    <!-- Sidebar -->
    <?php $this->load->view('admin/sidebar'); ?>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col overflow-y-auto">

        <!-- Header -->
        <?php $this->load->view('admin/header'); ?>

        <!-- Content Area -->
        <div class="p-8 space-y-8">

            <!-- Flash Messages -->
            <?php if ($this->session->flashdata('success')): ?>
                <div class="bg-emerald-500/20 border border-emerald-500 text-emerald-300 px-6 py-4 rounded-xl flex items-center gap-3">
                    <i class="bi bi-check-circle-fill text-lg"></i>
                    <span class="text-sm font-semibold"><?= $this->session->flashdata('success') ?></span>
                </div>
            <?php endif; ?>
            <?php if ($this->session->flashdata('error')): ?>
                <div class="bg-red-500/20 border border-red-500 text-red-300 px-6 py-4 rounded-xl flex items-center gap-3">
                    <i class="bi bi-exclamation-circle-fill text-lg"></i>
                    <span class="text-sm font-semibold"><?= $this->session->flashdata('error') ?></span>
                </div>
            <?php endif; ?>

            <!-- Title & Stats -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h2 class="font-display font-extrabold text-2xl text-white">Kelola Forum Diskusi</h2>
                    <p class="text-brand-light/70 text-xs mt-1">Moderasi semua topik diskusi dan komentar dari anggota keluarga.</p>
                </div>
                <div class="flex items-center gap-3">
                    <div class="bg-teal-900/60 border border-teal-800 rounded-xl px-4 py-2 flex items-center gap-2 text-sm text-teal-300">
                        <i class="bi bi-chat-left-text-fill"></i>
                        <span class="font-bold"><?= count($forums) ?></span>
                        <span class="text-white/50">topik</span>
                    </div>
                </div>
            </div>

            <!-- Search Filter -->
            <div class="bg-brand-dark/20 border border-brand-medium/20 rounded-2xl p-6 shadow-sm">
                <form method="GET" action="<?= base_url('admin/forum') ?>" class="flex flex-col md:flex-row gap-4">
                    <!-- Search Input -->
                    <div class="relative flex-1">
                        <i class="bi bi-search absolute left-4 top-3.5 text-white/40"></i>
                        <input type="text" name="search" value="<?= htmlspecialchars($search) ?>"
                               placeholder="Cari judul forum..."
                               class="w-full bg-[#1A2824] border border-[#4D6B67]/30 rounded-xl py-3 pl-11 pr-4 text-sm text-white placeholder-white/40 focus:outline-none focus:border-brand-medium transition-all">
                    </div>
                    <button type="submit"
                            class="bg-brand-medium hover:bg-brand-medium/90 border border-brand-medium text-white px-6 py-3 rounded-xl flex items-center gap-2 text-sm font-semibold transition-all">
                        <i class="bi bi-funnel-fill"></i>
                        <span>Filter</span>
                    </button>
                    <?php if (!empty($search)): ?>
                        <a href="<?= base_url('admin/forum') ?>"
                           class="border border-brand-medium/30 text-white/60 hover:text-white px-6 py-3 rounded-xl flex items-center gap-2 text-sm font-semibold transition-all">
                            <i class="bi bi-x-circle"></i>
                            <span>Reset</span>
                        </a>
                    <?php endif; ?>
                </form>
            </div>

            <!-- Table Card -->
            <div class="bg-gradient-to-b from-brand-dark/20 to-brand-dark/5 border border-brand-medium/20 rounded-2xl p-6 shadow-lg">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-[#4D6B67]/20">
                                <th class="pb-4 text-xs font-bold text-white/40 uppercase tracking-wider">Topik Forum</th>
                                <th class="pb-4 text-xs font-bold text-white/40 uppercase tracking-wider">Dibuat Oleh</th>
                                <th class="pb-4 text-xs font-bold text-white/40 uppercase tracking-wider">Komentar</th>
                                <th class="pb-4 text-xs font-bold text-white/40 uppercase tracking-wider">Tanggal</th>
                                <th class="pb-4 text-xs font-bold text-white/40 uppercase tracking-wider text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#4D6B67]/10">
                            <?php if (!empty($forums)): ?>
                                <?php foreach ($forums as $forum): ?>
                                    <tr class="hover:bg-brand-dark/10 transition-colors">
                                        <!-- Judul & Preview -->
                                        <td class="py-4 pr-4">
                                            <div class="font-semibold text-white text-sm max-w-xs">
                                                <?= htmlspecialchars($forum['title']) ?>
                                            </div>
                                            <?php if (!empty($forum['content'])): ?>
                                                <div class="text-xs text-white/40 mt-1 line-clamp-1 max-w-xs">
                                                    <?= htmlspecialchars(substr(strip_tags($forum['content']), 0, 80)) ?>...
                                                </div>
                                            <?php endif; ?>
                                        </td>

                                        <!-- Author -->
                                        <td class="py-4">
                                            <div class="flex items-center gap-2">
                                                <div class="w-7 h-7 rounded-full bg-brand-medium/40 flex items-center justify-center text-xs font-bold text-white border border-brand-medium/20">
                                                    <?= strtoupper(substr($forum['author_name'] ?? 'U', 0, 1)) ?>
                                                </div>
                                                <span class="text-sm text-white/80">
                                                    <?= htmlspecialchars($forum['author_name'] ?? 'Unknown') ?>
                                                </span>
                                            </div>
                                        </td>

                                        <!-- Jumlah Komentar -->
                                        <td class="py-4">
                                            <div class="flex items-center gap-1.5">
                                                <i class="bi bi-chat-dots text-teal-400 text-sm"></i>
                                                <span class="text-sm font-semibold text-white/80">
                                                    <?= number_format($forum['comment_count']) ?>
                                                </span>
                                                <span class="text-xs text-white/40">komentar</span>
                                            </div>
                                        </td>

                                        <!-- Tanggal -->
                                        <td class="py-4 text-sm text-white/60">
                                            <?php
                                                $ts = strtotime($forum['created_at']);
                                                $months_id = [1=>'Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
                                                echo date('j', $ts) . ' ' . $months_id[(int)date('n', $ts)] . ' ' . date('Y', $ts);
                                            ?>
                                        </td>

                                        <!-- Aksi -->
                                        <td class="py-4 text-right space-x-2">
                                            <a href="<?= base_url('forum/view/' . $forum['id']) ?>" target="_blank"
                                               class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-teal-500/10 text-teal-400 hover:bg-teal-500 hover:text-white border border-teal-500/20 transition-all"
                                               title="Lihat Detail">
                                                <i class="bi bi-eye-fill text-sm"></i>
                                            </a>
                                            <a href="<?= base_url('admin/forum_delete/' . $forum['id']) ?>"
                                               onclick="return confirm('Hapus topik forum ini? Semua komentar juga akan ikut terhapus.')"
                                               class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-brand-red/10 text-brand-red hover:bg-brand-red hover:text-white border border-brand-red/20 transition-all"
                                               title="Hapus Forum">
                                                <i class="bi bi-trash-fill text-sm"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="py-16 text-center">
                                        <div class="flex flex-col items-center gap-3 text-white/30">
                                            <i class="bi bi-chat-left-text text-4xl"></i>
                                            <span class="text-sm">
                                                <?= !empty($search) ? 'Tidak ada forum yang cocok dengan pencarian.' : 'Belum ada topik forum diskusi.' ?>
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </main>

</body>
</html>
