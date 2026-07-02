<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Reset Password</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-screen bg-teal-900 flex items-center justify-center">
<div class="w-full max-w-sm px-6 text-white">

  <?php if (!empty($errors)): ?>
    <div class="mb-4 text-red-400 text-sm">
      <?php foreach ($errors as $err): ?><p>• <?= htmlspecialchars($err) ?></p><?php endforeach; ?>
    </div>
  <?php endif; ?>

  <h1 class="text-2xl font-semibold mb-6">Password Baru</h1>

  <?= form_open('auth/reset_password/' . $token) ?>
    <div class="mb-5">
      <label class="block text-white/60 text-xs mb-2 uppercase">Password Baru</label>
      <input name="password" type="password" required minlength="8"
             class="w-full bg-transparent border-b border-white/30 py-2">
    </div>
    <div class="mb-6">
      <label class="block text-white/60 text-xs mb-2 uppercase">Konfirmasi Password</label>
      <input name="password_confirmation" type="password" required minlength="8"
             class="w-full bg-transparent border-b border-white/30 py-2">
    </div>
    <button type="submit" class="w-full border border-white/70 rounded-full py-3 uppercase text-sm font-semibold">
      Simpan Password
    </button>
  <?= form_close() ?>
</div>
</body>
</html>
