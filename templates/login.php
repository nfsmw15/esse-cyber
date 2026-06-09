<?php
/**
 * Content partial for /login (auth.login.render hook).
 *
 * @var array            $data
 * @var \EsseCyber\Theme $theme
 */
$renderIcon = [$theme, 'renderIcon'];
?>
<?php if (!empty($data['error'])): ?>
<div class="cyber-alert cyber-alert-danger"><?= htmlspecialchars($data['error']) ?></div>
<?php endif ?>

<div class="cyber-auth-panel">
    <form method="post" action="/login" class="cyber-auth-form">
        <input type="hidden" name="_csrf" value="<?= htmlspecialchars($data['csrfToken'] ?? '') ?>">
        <input type="hidden" name="_form" value="admin_login">
        <input type="hidden" name="redirect" value="<?= htmlspecialchars($data['redirect'] ?? '') ?>">

        <label for="cyber-login-email">E-Mail</label>
        <input id="cyber-login-email" type="email" name="login" autocomplete="username" autofocus required>

        <label for="cyber-login-password">Passwort</label>
        <input id="cyber-login-password" type="password" name="password" autocomplete="current-password" required>

        <button type="submit" class="cyber-btn cyber-auth-submit">// ANMELDEN</button>
    </form>

    <div class="d-none cyber-passkey-block" id="passkey-login-block">
        <div class="cyber-auth-separator"><span>ODER</span></div>
        <button type="button" id="passkey-login-btn" class="cyber-btn cyber-auth-submit">
            <?= $renderIcon('fingerprint') ?> Mit Passkey anmelden
        </button>
        <div class="d-none cyber-passkey-error" id="passkey-login-error"></div>
    </div>

    <div class="cyber-auth-links">
        <a href="/admin/forgot-password">Passwort vergessen?</a>
        <?php if (!empty($data['registrationEnabled'])): ?>
        <a href="/registrieren">Registrieren</a>
        <?php endif ?>
    </div>
</div>
