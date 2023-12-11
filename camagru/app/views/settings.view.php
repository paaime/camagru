<?php ob_start(); ?>
<?php if (!empty($errors)): ?>
    <div class="popup-error">
        <div class="error-wrapper">
            <?= implode("<br>", $errors) ?>
        </div>
        <i class="gg-close"></i>
    </div>
<?php endif; ?>
<div class="settings-wrapper card">
    <h3>Settings</h3>
    <form method="POST" action="<?= ROOT ?>/settings/changeEmail">
        <label for="email" class="form-label">Email address</label>
        <input name="email" type="email" class="form-control" id="email" aria-describedby="emailHelp"
            value="<?= $email ?>">
        <button type="submit">Submit</button>
    </form>
    <form method="POST" action="<?= ROOT ?>/settings/changeUsername">
        <label for="username" class="form-label">Username</label>
        <input name="username" type="text" class="form-control" id="username" aria-describedby="emailHelp"
            value="<?= $username ?>" />
        <button type="submit">Submit</button>
    </form>
    <form method="POST" action="<?= ROOT ?>/settings/changePassword">
        <label for="password" class="form-label">Password</label>
        <input name="password" type="password" class="form-control" id="password" aria-describedby="emailHelp">
        <button type="submit">Submit</button>
    </form>
    <form method="POST" action="<?= ROOT ?>/settings/changeEmailNotification" class="toggle-notifications">
        <label for="email-notification" class="form-label">Mail notification</label>
        <button class="hidden-submit" type="submit"></button>
        <?php if ($mail_notification): ?>
            <input type="checkbox" class="input-checkbox" id="email-notification" checked />
        <?php else: ?>
            <input type="checkbox" class="input-checkbox" id="email-notification" />
        <?php endif; ?>
        <label for="email-notification" class="toggle">
            <div class="slider"></div>
        </label>
    </form>
</div>
<script>
    let closeBtn = document.querySelector(".popup-error .gg-close");
    let popup = document.querySelector(".popup-error");

    closeBtn?.addEventListener("click", () => {
        popup.style.display = "none";
    });
</script>
<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>