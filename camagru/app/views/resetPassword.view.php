<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Camagru - Reset Password</title>

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
    <main>
        <form method="post" class="auth-wrapper">
            <a href="<?= ROOT ?>">
                <img src="<?= ROOT ?>/assets/images/logo.png" alt="Logo" class="logo" />
            </a>
            <h3>Reset Password</h3>
            <div class="input-wrapper">
                <label for="password">New Password</label>
                <input type="password" name="password" placeholder="Enter your new password" />
                <button type="submit">Change password</button>
            </div>
        </form>
    </main>

    <script>
        let closeBtn = document.querySelector(".popup-error .gg-close");
        let popup = document.querySelector(".popup-error");

        closeBtn?.addEventListener("click", () => {
            popup.style.display = "none";
        });
    </script>
</body>

</html>