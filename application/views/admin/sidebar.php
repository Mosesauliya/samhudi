<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$current_page = isset($active_menu) ? $active_menu : ($this->uri->segment(2) ? $this->uri->segment(2) : $this->uri->segment(1));
?>
<!-- ================= SIDEBAR ================= -->
<aside class="w-72 bg-brand-dark border-r border-brand-medium/30 flex flex-col shrink-0">
    
    <!-- Profile Section -->
    <div class="p-6 border-b border-brand-medium/30 flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-brand-medium to-brand-dark flex items-center justify-center text-white font-bold text-xl border border-brand-medium shadow-sm">
            <?= strtoupper(substr($admin_name ?? 'A', 0, 1)) ?>
        </div>
        <div>
            <h2 class="font-display font-bold text-sm tracking-tight text-white"><?= htmlspecialchars($admin_name ?? 'Admin') ?></h2>
            <p class="text-xs text-brand-light/80 mt-0.5 capitalize"><?= htmlspecialchars(str_replace('_', ' ', $admin_role ?? 'Administrator')) ?></p>
        </div>
    </div>

    <!-- Sidebar Navigation -->
    <nav class="flex-1 p-4 space-y-1.5 overflow-y-auto">
        
        <!-- Dashboard -->
        <a href="<?= base_url('admin') ?>" 
           class="flex items-center gap-3.5 px-4 py-3 rounded-lg text-sm font-medium transition-all <?= ($current_page == 'admin' || $current_page == 'dashboard') ? 'bg-gradient-to-r from-brand-medium to-brand-dark/20 text-white border-l-4 border-white shadow-md' : 'text-white/80 hover:text-white hover:bg-brand-medium/20' ?>">
            <i class="bi bi-grid-fill text-lg"></i>
            <span>Dashboard</span>
        </a>

        <!-- Kelola Silsilah -->
        <a href="<?= base_url('admin/silsilah') ?>" 
           class="flex items-center gap-3.5 px-4 py-3 rounded-lg text-sm font-medium transition-all <?= ($current_page == 'silsilah') ? 'bg-gradient-to-r from-brand-medium to-brand-dark/20 text-white border-l-4 border-white shadow-md' : 'text-white/80 hover:text-white hover:bg-brand-medium/20' ?>">
            <i class="bi bi-diagram-3 text-lg"></i>
            <span>Kelola Silsilah</span>
        </a>

        <!-- Kelola Wasiat -->
        <a href="#" 
           class="flex items-center gap-3.5 px-4 py-3 rounded-lg text-sm font-medium transition-all <?= ($current_page == 'wasiat') ? 'bg-gradient-to-r from-brand-medium to-brand-dark/20 text-white border-l-4 border-white shadow-md' : 'text-white/80 hover:text-white hover:bg-brand-medium/20' ?>">
            <i class="bi bi-file-earmark-text text-lg"></i>
            <span>Kelola Wasiat</span>
        </a>

        <!-- Kelola Forum Diskusi -->
        <a href="<?= base_url('admin/forum') ?>" 
           class="flex items-center gap-3.5 px-4 py-3 rounded-lg text-sm font-medium transition-all <?= ($current_page == 'forum') ? 'bg-gradient-to-r from-brand-medium to-brand-dark/20 text-white border-l-4 border-white shadow-md' : 'text-white/80 hover:text-white hover:bg-brand-medium/20' ?>">
            <i class="bi bi-chat-left-text text-lg"></i>
            <span>Kelola Forum Diskusi</span>
        </a>

        <!-- Kelola Berita -->
        <a href="<?= base_url('admin/berita') ?>" 
           class="flex items-center gap-3.5 px-4 py-3 rounded-lg text-sm font-medium transition-all <?= ($current_page == 'berita') ? 'bg-gradient-to-r from-brand-medium to-brand-dark/20 text-white border-l-4 border-white shadow-md' : 'text-white/80 hover:text-white hover:bg-brand-medium/20' ?>">
            <i class="bi bi-newspaper text-lg"></i>
            <span>Kelola Berita</span>
        </a>

        <!-- Kelola Yayasan -->
        <a href="#" 
           class="flex items-center gap-3.5 px-4 py-3 rounded-lg text-sm font-medium transition-all <?= ($current_page == 'yayasan') ? 'bg-gradient-to-r from-brand-medium to-brand-dark/20 text-white border-l-4 border-white shadow-md' : 'text-white/80 hover:text-white hover:bg-brand-medium/20' ?>">
            <i class="bi bi-bank text-lg"></i>
            <span>Kelola Yayasan</span>
        </a>

        <!-- Kelola Pengguna -->
        <a href="#" 
           class="flex items-center gap-3.5 px-4 py-3 rounded-lg text-sm font-medium transition-all <?= ($current_page == 'pengguna') ? 'bg-gradient-to-r from-brand-medium to-brand-dark/20 text-white border-l-4 border-white shadow-md' : 'text-white/80 hover:text-white hover:bg-brand-medium/20' ?>">
            <i class="bi bi-people text-lg"></i>
            <span>Kelola Pengguna</span>
        </a>

        <!-- Pengaturan -->
        <a href="#" 
           class="flex items-center gap-3.5 px-4 py-3 rounded-lg text-sm font-medium transition-all <?= ($current_page == 'pengaturan') ? 'bg-gradient-to-r from-brand-medium to-brand-dark/20 text-white border-l-4 border-white shadow-md' : 'text-white/80 hover:text-white hover:bg-brand-medium/20' ?>">
            <i class="bi bi-gear text-lg"></i>
            <span>Pengaturan</span>
        </a>

    </nav>

    <!-- Footer / Logout -->
	<div class="p-4 border-t border-brand-medium/30">
		<a href="<?= base_url('auth/logout') ?>" 
		class="flex items-center justify-center gap-3 px-4 py-3 rounded-lg text-sm font-bold text-white bg-red-500 hover:bg-red-600 transition-all shadow-md">
			<i class="bi bi-box-arrow-right text-lg"></i>
			<span>Logout</span>
		</a>
	</div>

</aside>
