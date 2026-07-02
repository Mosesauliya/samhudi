<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Keluarga H.M Samhudi</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <!-- Bootstrap Icons -->
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
                        gold: {
                            400: '#D4B571',
                            500: '#C29A4E',
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
        /* Slim Scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #15201E; }
        ::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.1); border-radius: 999px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(255, 255, 255, 0.2); }
    </style>
</head>
<body class="bg-teal-950 text-white font-body min-h-screen flex">

    <!-- ================= SIDEBAR ================= -->
    <aside class="w-72 bg-teal-900 border-r border-teal-800 flex flex-col shrink-0">
        
        <!-- Profile Section -->
        <div class="p-6 border-b border-teal-800 flex items-center gap-4">
            <div class="w-12 h-12 rounded bg-teal-800 flex items-center justify-center text-teal-400 font-bold text-xl border border-teal-700">
                A
            </div>
            <div>
                <h2 class="font-display font-bold text-sm tracking-tight text-white"><?= htmlspecialchars($admin_name) ?></h2>
                <p class="text-xs text-teal-400 mt-0.5 capitalize"><?= htmlspecialchars(str_replace('_', ' ', $admin_role)) ?></p>
            </div>
        </div>

        <!-- Sidebar Navigation -->
        <nav class="flex-1 p-4 space-y-1.5 overflow-y-auto">
            
            <a href="<?= base_url('admin') ?>" class="flex items-center gap-3.5 px-4 py-3 rounded-lg text-sm font-medium bg-teal-800 text-gold-400 border-l-4 border-gold-400 transition-all">
                <i class="bi bi-grid-fill text-lg"></i>
                Dashboard
            </a>

            <a href="#" class="flex items-center gap-3.5 px-4 py-3 rounded-lg text-sm font-medium text-teal-400 hover:text-white hover:bg-teal-800/50 transition-all">
                <i class="bi bi-diagram-3 text-lg"></i>
                Kelola Silsilah
            </a>

            <a href="#" class="flex items-center gap-3.5 px-4 py-3 rounded-lg text-sm font-medium text-teal-400 hover:text-white hover:bg-teal-800/50 transition-all">
                <i class="bi bi-file-earmark-text text-lg"></i>
                Kelola Wasiat
            </a>

            <a href="#" class="flex items-center gap-3.5 px-4 py-3 rounded-lg text-sm font-medium text-teal-400 hover:text-white hover:bg-teal-800/50 transition-all">
                <i class="bi bi-chat-left-text text-lg"></i>
                Kelola Forum Diskusi
            </a>

            <a href="#" class="flex items-center gap-3.5 px-4 py-3 rounded-lg text-sm font-medium text-teal-400 hover:text-white hover:bg-teal-800/50 transition-all">
                <i class="bi bi-newspaper text-lg"></i>
                Kelola Berita
            </a>

            <a href="#" class="flex items-center gap-3.5 px-4 py-3 rounded-lg text-sm font-medium text-teal-400 hover:text-white hover:bg-teal-800/50 transition-all">
                <i class="bi bi-bank text-lg"></i>
                Kelola Yayasan
            </a>

            <a href="#" class="flex items-center gap-3.5 px-4 py-3 rounded-lg text-sm font-medium text-teal-400 hover:text-white hover:bg-teal-800/50 transition-all">
                <i class="bi bi-people text-lg"></i>
                Kelola Pengguna
            </a>

            <a href="#" class="flex items-center gap-3.5 px-4 py-3 rounded-lg text-sm font-medium text-teal-400 hover:text-white hover:bg-teal-800/50 transition-all">
                <i class="bi bi-gear text-lg"></i>
                Pengaturan
            </a>

        </nav>

        <!-- Footer / Logout -->
        <div class="p-4 border-t border-teal-800">
            <a href="<?= base_url('auth/logout') ?>" class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium text-red-400 hover:bg-red-950/20 transition-all">
                <i class="bi bi-box-arrow-left text-lg"></i>
                Keluar / Logout
            </a>
        </div>

    </aside>

    <!-- ================= MAIN CONTENT ================= -->
    <main class="flex-1 flex flex-col overflow-y-auto">
        
        <!-- Header -->
        <header class="h-20 bg-teal-900 border-b border-teal-800 flex items-center justify-between px-8 shrink-0">
            <div>
                <h1 class="font-display font-bold text-lg text-white">Dashboard Overview</h1>
                <p class="text-xs text-teal-400 mt-0.5">Selamat datang kembali, <?= htmlspecialchars($admin_name) ?></p>
            </div>
            
            <button onclick="window.location.reload();" class="flex items-center gap-2 border border-teal-700 bg-teal-800 hover:bg-teal-700 text-teal-300 hover:text-white px-4 py-2 rounded-lg text-xs font-semibold tracking-wide transition-all shadow-sm">
                <i class="bi bi-arrow-clockwise text-sm"></i>
                Refresh
            </button>
        </header>

        <!-- Body / Dashboard Content -->
        <div class="p-8 space-y-8">

            <!-- Welcome Message Widget -->
            <div class="relative overflow-hidden bg-gradient-to-r from-teal-900 to-teal-800 border border-teal-800 rounded-2xl p-8 flex items-center justify-between shadow-lg">
                <div class="space-y-2 z-10">
                    <h2 class="font-display font-extrabold text-2xl text-white">Halo, <?= htmlspecialchars($admin_name) ?>!</h2>
                    <p class="text-teal-300 text-sm max-w-xl">Halaman ini digunakan untuk mengelola data silsilah keluarga besar, persetujuan forum diskusi, publikasi berita terbaru, penginputan data yayasan, dan pengelolaan data wasiat.</p>
                </div>
                <i class="bi bi-shield-lock-fill text-8xl text-teal-700/20 absolute right-8 bottom-0"></i>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                <!-- Stat Card 1 -->
                <div class="bg-teal-900/60 hover:bg-teal-900 border border-teal-800 rounded-xl p-6 transition-all duration-300 flex items-center justify-between">
                    <div>
                        <span class="text-xs font-semibold text-teal-400 uppercase tracking-wider">Total Anggota</span>
                        <h3 class="text-3xl font-extrabold font-display mt-2 text-white"><?= number_format($total_members) ?></h3>
                    </div>
                    <div class="w-12 h-12 rounded-lg bg-teal-800 flex items-center justify-center text-teal-300 text-xl border border-teal-700">
                        <i class="bi bi-people-fill"></i>
                    </div>
                </div>

                <!-- Stat Card 2 -->
                <div class="bg-teal-900/60 hover:bg-teal-900 border border-teal-800 rounded-xl p-6 transition-all duration-300 flex items-center justify-between">
                    <div>
                        <span class="text-xs font-semibold text-teal-400 uppercase tracking-wider">Berita Aktif</span>
                        <h3 class="text-3xl font-extrabold font-display mt-2 text-white"><?= number_format($total_news) ?></h3>
                    </div>
                    <div class="w-12 h-12 rounded-lg bg-teal-800 flex items-center justify-center text-teal-300 text-xl border border-teal-700">
                        <i class="bi bi-newspaper"></i>
                    </div>
                </div>

                <!-- Stat Card 3 -->
                <div class="bg-teal-900/60 hover:bg-teal-900 border border-teal-800 rounded-xl p-6 transition-all duration-300 flex items-center justify-between">
                    <div>
                        <span class="text-xs font-semibold text-teal-400 uppercase tracking-wider">Forum Diskusi</span>
                        <h3 class="text-3xl font-extrabold font-display mt-2 text-white"><?= number_format($total_forums) ?></h3>
                    </div>
                    <div class="w-12 h-12 rounded-lg bg-teal-800 flex items-center justify-center text-teal-300 text-xl border border-teal-700">
                        <i class="bi bi-chat-left-text-fill"></i>
                    </div>
                </div>

                <!-- Stat Card 4 -->
                <div class="bg-teal-900/60 hover:bg-teal-900 border border-teal-800 rounded-xl p-6 transition-all duration-300 flex items-center justify-between">
                    <div>
                        <span class="text-xs font-semibold text-teal-400 uppercase tracking-wider">Data Wasiat</span>
                        <h3 class="text-3xl font-extrabold font-display mt-2 text-white"><?= number_format($total_wills) ?></h3>
                    </div>
                    <div class="w-12 h-12 rounded-lg bg-teal-800 flex items-center justify-center text-teal-300 text-xl border border-teal-700">
                        <i class="bi bi-file-earmark-text-fill"></i>
                    </div>
                </div>

            </div>

            <!-- Future Features Placeholder / Notice Section -->
            <div class="bg-teal-900/30 border border-teal-800/60 rounded-xl p-6">
                <h3 class="font-display font-bold text-sm text-teal-300 uppercase tracking-wider mb-4">Informasi Sistem</h3>
                <div class="text-teal-400/80 text-sm leading-relaxed space-y-2">
                    <p>• Menu navigasi di sidebar kiri dapat diintegrasikan dengan modul CRUD masing-masing sesuai kebutuhan.</p>
                    <p>• Hak akses halaman dashboard ini dilindungi menggunakan otorisasi server-side CodeIgniter (hanya user dengan role <strong>admin</strong> dan <strong>super_admin</strong> yang diperbolehkan masuk).</p>
                </div>
            </div>

        </div>

    </main>

</body>
</html>
