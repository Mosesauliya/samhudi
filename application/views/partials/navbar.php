<nav class="bg-white border-b border-gray-100 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">

        <div class="font-display font-bold text-lg text-teal-900 tracking-tight">
            <a href="<?= base_url() ?>">HM Samhudi</a>
        </div>

        <!-- Desktop Menu -->
        <ul class="hidden md:flex items-center gap-20 font-display font-semibold text-sm tracking-wide text-teal-900/90">
            <li>
                <a href="<?= base_url() ?>" class="relative py-2 hover:text-teal-600 transition-colors duration-300 group">
                    Home
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-teal-600 transition-all duration-300 group-hover:w-full"></span>
                </a>
            </li>
            <li>
                <a href="<?= base_url('Wasiat') ?>" class="relative py-2 hover:text-teal-600 transition-colors duration-300 group">
                    Wasiat
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-teal-600 transition-all duration-300 group-hover:w-full"></span>
                </a>
            </li>
            <li>
                <a href="#" class="relative py-2 hover:text-teal-600 transition-colors duration-300 group">
                    Yayasan
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-teal-600 transition-all duration-300 group-hover:w-full"></span>
                </a>
            </li>
            <li>
                <a href="<?= base_url('Familytree') ?>" class="relative py-2 hover:text-teal-600 transition-colors duration-300 group">
                    Data Keluarga
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-teal-600 transition-all duration-300 group-hover:w-full"></span>
                </a>
            </li>
            <li>
                <a href="<?= base_url('forum') ?>" class="relative py-2 hover:text-teal-600 transition-colors duration-300 group">
                    Forum Diskusi
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-teal-600 transition-all duration-300 group-hover:w-full"></span>
                </a>
            </li>
        </ul>

        <!-- Desktop Login -->
        <div class="hidden md:flex items-center">
            <a href="<?= base_url('auth/') ?>" class="font-display font-semibold text-sm bg-teal-900 text-white px-5 py-2.5 rounded-full shadow-sm hover:bg-teal-800 transition-all duration-300 transform hover:-translate-y-0.5">
                Masuk
            </a>
        </div>

        <!-- Mobile Button -->
        <button id="menu-btn" class="block md:hidden text-3xl text-teal-900 focus:outline-none">
            ☰
        </button>

    </div>

    <!-- Mobile Overlay -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-40 md:hidden opacity-0 pointer-events-none transition-opacity duration-300"></div>

    <!-- Mobile Sidebar -->
    <div id="mobile-menu" class="fixed top-0 right-0 h-full w-[75%] max-w-sm bg-teal-900 z-50 md:hidden translate-x-full transition-transform duration-300 ease-in-out shadow-[-5px_0_20px_rgba(0,0,0,0.3)]">
        <div class="flex items-center justify-between p-6 border-b border-white/20">
            <span class="font-display font-bold text-lg text-white">Menu</span>
            <button id="close-sidebar" class="text-3xl text-white/80 hover:text-white focus:outline-none">&times;</button>
        </div>
        <ul class="font-display font-semibold text-base tracking-wide text-white/80 space-y-1 p-6">
            <li>
                <a href="<?= base_url() ?>" class="block py-2 hover:text-white transition-colors duration-200">Home</a>
            </li>
            <li>
                <a href="<?= base_url('Wasiat') ?>" class="block py-2 hover:text-white transition-colors duration-200">Wasiat</a>
            </li>
            <li>
                <a href="#" class="block py-2 hover:text-white transition-colors duration-200">Yayasan</a>
            </li>
            <li>
                <a href="<?= base_url('Familytree') ?>" class="block py-2 hover:text-white transition-colors duration-200">Data Keluarga</a>
            </li>
            <li>
                <a href="<?= base_url('forum') ?>" class="block py-2 hover:text-white transition-colors duration-200">Forum Diskusi</a>
            </li>
        </ul>
        <div class="px-6 pb-6">
            <hr class="border-white/20 mb-4">
            <a href="<?= base_url('auth/') ?>" class="block w-full text-center font-display font-semibold text-sm bg-white text-teal-900 px-5 py-2.5 rounded-full hover:bg-gray-100 transition-colors duration-200">Masuk</a>
        </div>
    </div>
</nav>

<script>
const menuBtn = document.getElementById('menu-btn');
const closeBtn = document.getElementById('close-sidebar');
const mobileMenu = document.getElementById('mobile-menu');
const overlay = document.getElementById('sidebar-overlay');

function openSidebar() {
    mobileMenu.classList.remove('translate-x-full');
    mobileMenu.classList.add('translate-x-0');
    overlay.classList.remove('opacity-0', 'pointer-events-none');
    overlay.classList.add('opacity-100');
    document.body.style.overflow = 'hidden';
}

function closeSidebar() {
    mobileMenu.classList.remove('translate-x-0');
    mobileMenu.classList.add('translate-x-full');
    overlay.classList.remove('opacity-100');
    overlay.classList.add('opacity-0', 'pointer-events-none');
    document.body.style.overflow = '';
}

menuBtn.addEventListener('click', openSidebar);
closeBtn.addEventListener('click', closeSidebar);
overlay.addEventListener('click', closeSidebar);
</script>