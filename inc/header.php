<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<nav class="navbar navbar-expand-lg shadow-sm" style="background: linear-gradient(90deg, #f5945c, #fec76f);">
  <div class="container">
    <a class="navbar-brand text-white fw-bold bg-white rounded-2 m-0 p-0" href="<?= htmlspecialchars($BASE_URL . '/public/index.php') ?>"><img src="../assets/logo-mit-school-of-distance-education.png"   alt=""></a>
    <div class="ms-auto">
      <?php if (!empty($_SESSION['admin_logged_in'])): ?>
        <a href="<?= htmlspecialchars($BASE_URL . '/admin/send_newsletter.php') ?>" class="btn btn-outline-light btn-sm me-2">Admin</a>
        <a href="<?= htmlspecialchars($BASE_URL . '/admin/logout.php') ?>" class="btn btn-danger btn-sm">Logout</a>
      <?php else: ?>
        <button class="btn btn-light btn-md" data-bs-toggle="modal" data-bs-target="#subscribeModal">Subscribe</button>
      <?php endif; ?>
    </div>
  </div>
</nav>
