<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Camagru</title>

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@100;200;300;400;500;600;700&display=swap"
        rel="stylesheet" />

    <link href="<?= ROOT ?>/assets/css/template.css" rel="stylesheet">

    <!-- Icon -->
    <link href="https://css.gg/css" rel="stylesheet" />
</head>

<body>
    <header>
        <div class="wrapper">
            <a href="<?= ROOT ?>/">
                <img src="<?= ROOT ?>/assets/images/logo.png" alt="Logo" class="logo" />
            </a>
            <div class="middle-wrapper">
                <a href="<?= ROOT ?>/">
                    <i class="gg-home-alt" style="margin-bottom: -5px; margin-right: 5px"></i>
                    <p>Home</p>
                </a>
                <a href="<?= ROOT ?>/gallery">
                    <i class="gg-feed" style="margin-right: 15px"></i>
                    <p>Feed</p>
                </a>
                <?php if (isset($_SESSION['USER'])): ?>
                    <a href="<?= ROOT ?>/settings">
                        <i class="gg-options" style="margin-right: 8px"></i>
                        <p>Settings</p>
                    </a>
                <?php endif; ?>
                <?php if (isset($_SESSION['USER'])): ?>
                    <a href="<?= ROOT ?>/logout">
                        <i class="gg-log-out" style="margin-right: 10px"></i>
                        <p>Logout</p>
                    </a>
                <?php endif; ?>
            </div>
            <div class="right-wrapper">
                <a href="<?= ROOT ?>/camera" class="add-photo">
                    <div class="plus">
                        <i class="gg-math-plus"></i>
                    </div>
                    <p>Add photo</p>
                </a>
            </div>
        </div>
    </header>
    <main>
        <?= $content ?>
    </main>
    <footer>
        <div class="wrapper">
            <p>Made with ❤️ by paime</p>
        </div>
    </footer>

</body>

</html>