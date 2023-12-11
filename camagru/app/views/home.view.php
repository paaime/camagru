<?php ob_start(); ?>
<div class="home-wrapper">

  <section class="header">
    <h1>Camagru</h1>
    <p>Share and mix photos with the world!</p>
  </section>
  <section class="features">
    <div class="container">
      <h2>Features</h2>
      <div class="feature">
        <img src="<?= ROOT ?>/assets/images/home_1.jpg" alt="Photo Sharing">
        <h3>Photo Sharing</h3>
        <p>Share your favorite moments with friends and the community.</p>
      </div>
      <div class="feature">
        <img src="<?= ROOT ?>/assets/images/home_2.jpg" alt="Photo Mixing">
        <h3>Photo Mixing</h3>
        <p>Create unique photos by blending two images together in a fun and creative way.</p>
      </div>
    </div>
  </section>

  <section class="cta">
    <div class="container">
      <h2>Join Camagru Today!</h2>
      <p>Sign up now to start sharing and mixing photos with the Camagru community.</p>
      <a href="<?= ROOT ?>/register" class="btn">Sign Up</a>
    </div>
  </section>
</div>
<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>