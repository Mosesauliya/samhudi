<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Lupa Password</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-screen bg-teal-900 flex items-center justify-center">
<div class="w-full max-w-sm px-6 text-white">

  <?php if (!empty($message)): ?>
    <p class="mb-4 text-green-400 text-sm"><?= htmlspecialchars($message) ?></p>
  <?php endif; ?>
  <?php if (!empty($errors)): ?>
    <div class="mb-4 text-red-400 text-sm">
      <?php foreach ($errors as $err): ?><p>• <?= htmlspecialchars($err) ?></p><?php endforeach; ?>
    </div>
  <?php endif; ?>

  <h1 class="text-2xl font-semibold mb-6">Lupa Password</h1>

  <?= form_open('auth/forgot_password') ?>
    <input name="email" type="email" required
           placeholder="nama@email.com" class="w-full bg-transparent border-b border-white/30 py-2 mb-6">
    <button type="submit" class="w-full border border-white/70 rounded-full py-3 uppercase text-sm font-semibold">
      Kirim Link Reset
    </button>
  <?= form_close() ?>
</div>
</body>
</html>
