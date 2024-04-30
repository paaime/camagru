<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <title>Camagru - Register</title>

  <!-- Icon -->
  <link href="https://css.gg/css" rel="stylesheet" />
  <!-- Google Font -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@100;200;300;400;500;600;700&display=swap"
    rel="stylesheet" />

  <!-- Custom styles for this template -->
  <link href="<?= ROOT ?>/assets/css/auth.css" rel="stylesheet">
</head>

<body>
  <?php if (!empty($errors)): ?>
    <div class="popup-error">
      <div class="error-wrapper">
        <?= implode("<br>", $errors) ?>
      </div>
      <i class="gg-close"></i>
    </div>
  <?php endif; ?>
  <?php if (!empty($success)): ?>
    <div class="popup-success">
      <div class="success-wrapper">
        <?= implode("<br>", $success) ?>
      </div>
      <i class="gg-close"></i>
    </div>
  <?php endif; ?>
  <main>
    <form method="post" class="auth-wrapper">
      <a href="<?= ROOT ?>">
        <img src="<?= ROOT ?>/assets/images/logo.png" alt="Logo" class="logo" />
      </a>
      <h3>Register</h3>
      <div class="input-wrapper">
        <label for="email">Email</label>
        <input type="email" name="email" placeholder="Enter your email" id="email" autocomplete="email" />
        <label for="username">Username</label>
        <input type="text" name="username" placeholder="Enter your username" id="username" autocomplete="off" />
        <label for="password">Password</label>
        <input type="password" name="password" placeholder="Enter your password" id="password" autocomplete="off" />
        <button type="submit">Register</button>
      </div>
      <div class="redirect">
        <h3>Already have an account ?</h3>
        <a href="<?= ROOT ?>/login">Login</a>
      </div>
    </form>
  </main>

  <script>
    let closeBtnError = document.querySelector(".popup-error .gg-close");
    let closeBtnSuccess = document.querySelector(".popup-success .gg-close");
    let popupError = document.querySelector(".popup-error");
    let popupSuccess = document.querySelector(".popup-success");

    closeBtnError?.addEventListener("click", () => {
      popupError.style.display = "none";
    });

    closeBtnSuccess?.addEventListener("click", () => {
      popupSuccess.style.display = "none";
    });
  </script>
</body>

</html>