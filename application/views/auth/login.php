<?php
/**
 * Login / Sign Up — Keluarga H.M Samhudi
 * ------------------------------------------------------------------
 * Ganti YOUR_PHOTO.jpg di <img> dengan foto keluarga lo.
 * Backend: auth/login.php & auth/register.php
 * ------------------------------------------------------------------
 */
session_start();
$errors = $_SESSION['errors'] ?? [];
$old    = $_SESSION['old'] ?? [];
unset($_SESSION['errors'], $_SESSION['old']);
$mode = isset($_GET['mode']) && $_GET['mode'] === 'signup' ? 'signup' : 'login';
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Masuk — Keluarga H.M Samhudi</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          teal: {
            950: '#0F211F',
            900: '#1B3835',
            800: '#22443F',
            700: '#2E564F',
            600: '#3D6C63',
          },
          gold: {
            400: '#D4B571',
            500: '#C29A4E',
          },
        },
        fontFamily: {
          display: ['"Plus Jakarta Sans"', 'sans-serif'],
          body: ['Inter', 'sans-serif'],
        },
        keyframes: {
          fadeIn: {
            '0%':   { opacity: '0', transform: 'translateY(10px)' },
            '100%': { opacity: '1', transform: 'translateY(0)' },
          },
        },
        animation: {
          'fade-in': 'fadeIn .5s cubic-bezier(.22,.61,.36,1) both',
        },
      },
    },
  };
</script>
<style>
  * { font-family: 'Inter', sans-serif; }
  .font-display { font-family: 'Plus Jakarta Sans', sans-serif; }

  /* Underline-only inputs */
  .input-line {
    background: transparent;
    border: none;
    border-bottom: 1px solid rgba(255,255,255,0.25);
    border-radius: 0;
    color: #fff;
    outline: none;
    width: 100%;
    padding: 10px 0;
    font-size: 0.9rem;
    transition: border-color .2s;
  }
  .input-line::placeholder { color: rgba(255,255,255,0.35); }
  .input-line:focus { border-bottom-color: rgba(255,255,255,0.8); }
  .input-line:-webkit-autofill,
  .input-line:-webkit-autofill:focus {
    -webkit-box-shadow: 0 0 0 1000px #22443F inset;
    -webkit-text-fill-color: #fff;
    caret-color: #fff;
  }

  /* Panel swap */
  .swap-panel[data-hidden="true"]  { display: none; }
  .swap-panel[data-hidden="false"] { display: block; animation: fadeIn .45s cubic-bezier(.22,.61,.36,1) both; }

  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to   { opacity: 1; transform: translateY(0); }
  }

  /* Checkbox */
  input[type="checkbox"] { accent-color: #D4B571; }
</style>
</head>
<body class="h-screen overflow-hidden bg-teal-900 font-body">

  <div class="grid grid-cols-1 md:grid-cols-[52%_48%] h-full">

    <!-- ============ LEFT: PHOTO ============ -->
    <div class="relative hidden md:block h-full overflow-hidden">

      <!-- Swap btn "Sign up / Login" — gaya outline pill di atas foto -->
      <div class="absolute bottom-10 left-10 z-20">
        <!-- shown when mode=login → prompt to sign up -->
        <div data-hero="login" data-hidden="<?= $mode === 'login' ? 'false' : 'true' ?>" class="swap-panel">
          <button type="button" data-tab-target="signup"
                  class="tab-toggle inline-flex items-center gap-2 border border-white text-white rounded-full px-7 py-2.5 text-sm font-semibold tracking-wide hover:bg-white hover:text-teal-900 transition-all duration-300">
            Daftar Sekarang
          </button>
        </div>
        <!-- shown when mode=signup → prompt to log in -->
        <div data-hero="signup" data-hidden="<?= $mode === 'signup' ? 'false' : 'true' ?>" class="swap-panel">
          <button type="button" data-tab-target="login"
                  class="tab-toggle inline-flex items-center gap-2 border border-white text-white rounded-full px-7 py-2.5 text-sm font-semibold tracking-wide hover:bg-white hover:text-teal-900 transition-all duration-300">
            Masuk Sekarang
          </button>
        </div>
      </div>

      <!-- Photo — ganti src="YOUR_PHOTO.jpg" dengan foto keluarga -->
      <img src="<?= base_url('assets/img/login.jpeg') ?>" alt="Keluarga H.M Samhudi"
           class="absolute inset-0 w-full h-full object-cover object-center"
           onerror="this.style.display='none'">

      <!-- Fallback gradient kalau foto belum ada -->
      <div class="absolute inset-0 bg-gradient-to-br from-teal-800/80 via-teal-900/60 to-teal-950/80"></div>
    </div>

    <!-- ============ RIGHT: FORM PANEL ============ -->
    <div class="relative flex flex-col justify-center px-10 sm:px-14 md:px-16 lg:px-20 h-full bg-teal-800">

      <!-- Back button -->
      <a href="YOUR_URL_HERE"
         class="absolute top-7 right-8 inline-flex items-center gap-1.5 text-white/50 hover:text-white/90 text-sm font-medium transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
        </svg>
        Kembali
      </a>

      <div class="w-full max-w-sm mx-auto">

        <!-- Error flash -->
        <?php if (!empty($errors)): ?>
          <div class="mb-6 text-red-300 text-sm space-y-1">
            <?php foreach ($errors as $err): ?>
              <p>• <?= htmlspecialchars($err) ?></p>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

        <!-- -------- LOGIN FORM -------- -->
        <form id="form-login" data-panel="login" data-hidden="<?= $mode === 'login' ? 'false' : 'true' ?>"
              class="swap-panel" action="auth/login.php" method="POST" autocomplete="on">

          <h1 class="font-display text-white text-3xl font-semibold mb-10 tracking-tight">Log In</h1>

          <div class="space-y-8">

            <div>
              <label for="login-email" class="block text-white/60 text-xs font-medium mb-2 tracking-wide uppercase">
                Email Address <span class="text-red-400">*</span>
              </label>
              <input id="login-email" name="identifier" type="text" required
                     value="<?= htmlspecialchars($old['identifier'] ?? '') ?>"
                     placeholder="nama@email.com"
                     class="input-line">
            </div>

            <div>
              <label for="login-password" class="block text-white/60 text-xs font-medium mb-2 tracking-wide uppercase">
                Password <span class="text-red-400">*</span>
              </label>
              <input id="login-password" name="password" type="password" required
                     placeholder="••••••••"
                     class="input-line">
            </div>

          </div>

          <div class="flex items-center gap-2 mt-6">
            <input type="checkbox" id="remember" name="remember" class="w-3.5 h-3.5">
            <label for="remember" class="text-white/60 text-sm select-none cursor-pointer">Remember me</label>
          </div>

          <div class="mt-8 space-y-4">
            <button type="submit"
                    class="w-full border border-white/70 text-white font-display font-semibold tracking-widest text-sm uppercase rounded-full py-3.5 hover:bg-white hover:text-teal-900 transition-all duration-300">
              LOG IN
            </button>

            <p class="text-center">
              <a href="lupa-password.php" class="text-white/50 hover:text-white/80 text-sm transition-colors">
                Forgot Password?
              </a>
            </p>

            <!-- mobile only swap -->
            <p class="text-center text-white/50 text-sm md:hidden">
              Belum punya akun?
              <button type="button" data-tab-target="signup" class="tab-toggle text-gold-400 font-semibold">Daftar</button>
            </p>
          </div>

        </form>

        <!-- -------- SIGN UP FORM -------- -->
        <form id="form-signup" data-panel="signup" data-hidden="<?= $mode === 'signup' ? 'false' : 'true' ?>"
              class="swap-panel" action="auth/register.php" method="POST" autocomplete="on">

          <h1 class="font-display text-white text-3xl font-semibold mb-10 tracking-tight">Sign Up</h1>

          <div class="space-y-8">

            <div>
              <label for="signup-name" class="block text-white/60 text-xs font-medium mb-2 tracking-wide uppercase">
                Nama Lengkap <span class="text-red-400">*</span>
              </label>
              <input id="signup-name" name="full_name" type="text" required
                     value="<?= htmlspecialchars($old['full_name'] ?? '') ?>"
                     placeholder="Sesuai KTP"
                     class="input-line">
            </div>

            <div>
              <label for="signup-email" class="block text-white/60 text-xs font-medium mb-2 tracking-wide uppercase">
                Email Address <span class="text-red-400">*</span>
              </label>
              <input id="signup-email" name="email" type="email" required
                     value="<?= htmlspecialchars($old['email'] ?? '') ?>"
                     placeholder="nama@email.com"
                     class="input-line">
            </div>

            <div>
              <label for="signup-password" class="block text-white/60 text-xs font-medium mb-2 tracking-wide uppercase">
                Password <span class="text-red-400">*</span>
              </label>
              <input id="signup-password" name="password" type="password" required minlength="8"
                     placeholder="Minimal 8 karakter"
                     class="input-line">
            </div>

          </div>

          <div class="flex items-start gap-2 mt-6">
            <input type="checkbox" id="agree" name="agree" required class="w-3.5 h-3.5 mt-0.5">
            <label for="agree" class="text-white/60 text-sm select-none cursor-pointer leading-snug">
              Saya menyetujui <a href="#" class="text-gold-400 hover:text-gold-500 underline">Ketentuan &amp; Privasi</a>
            </label>
          </div>

          <div class="mt-8 space-y-4">
            <button type="submit"
                    class="w-full border border-white/70 text-white font-display font-semibold tracking-widest text-sm uppercase rounded-full py-3.5 hover:bg-white hover:text-teal-900 transition-all duration-300">
              DAFTAR
            </button>

            <!-- mobile only swap -->
            <p class="text-center text-white/50 text-sm md:hidden">
              Sudah punya akun?
              <button type="button" data-tab-target="login" class="tab-toggle text-gold-400 font-semibold">Masuk</button>
            </p>
          </div>

        </form>

      </div>
    </div>

  </div>

<script>
  function setMode(mode) {
    document.querySelectorAll('[data-panel]').forEach(function(el) {
      el.setAttribute('data-hidden', el.getAttribute('data-panel') === mode ? 'false' : 'true');
    });
    document.querySelectorAll('[data-hero]').forEach(function(el) {
      el.setAttribute('data-hidden', el.getAttribute('data-hero') === mode ? 'false' : 'true');
    });
    var url = new URL(window.location);
    url.searchParams.set('mode', mode);
    window.history.replaceState({}, '', url);
  }

  document.querySelectorAll('.tab-toggle').forEach(function(el) {
    el.addEventListener('click', function() {
      setMode(el.getAttribute('data-tab-target'));
    });
  });
</script>
</body>
</html>
