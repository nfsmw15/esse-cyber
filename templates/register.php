<?php
/**
 * Content partial for /registrieren.
 *
 * @var array $data
 */
$formData = $data['formData'] ?? [];
?>
<?php if (empty($data['registrationEnabled'])): ?>
<div class="cyber-alert cyber-alert-info">Registrierung ist derzeit deaktiviert.</div>
<?php elseif (!empty($data['done'])): ?>
<div class="cyber-alert cyber-alert-success">
    Account erstellt! Du kannst dich jetzt <a href="/login">anmelden</a>.
</div>
<?php else: ?>

<?php if (!empty($data['errors'])): ?>
<div class="cyber-alert cyber-alert-danger">
    <?php foreach ($data['errors'] as $error): ?>
    <div><?= htmlspecialchars($error) ?></div>
    <?php endforeach ?>
</div>
<?php endif ?>

<form method="post" action="/registrieren" class="cyber-auth-form">
    <input type="hidden" name="_csrf" value="<?= htmlspecialchars($data['csrfToken'] ?? '') ?>">

    <label for="cyber-register-name">Anzeigename</label>
    <input id="cyber-register-name"
           type="text"
           name="display_name"
           value="<?= htmlspecialchars($formData['display_name'] ?? '') ?>"
           required
           autofocus>

    <label for="cyber-register-email">E-Mail</label>
    <input id="cyber-register-email"
           type="email"
           name="email"
           value="<?= htmlspecialchars($formData['email'] ?? '') ?>"
           autocomplete="email"
           required>

    <label for="cyber-register-password">Passwort</label>
    <input id="cyber-register-password" type="password" name="password" autocomplete="new-password" required>
    <div class="cyber-form-hint">Mindestens 10 Zeichen</div>

    <label for="cyber-register-password-confirm">Passwort bestaetigen</label>
    <input id="cyber-register-password-confirm" type="password" name="password_confirm" autocomplete="new-password" required>

    <label for="cyber-register-captcha"><?= htmlspecialchars($data['captchaQuestion'] ?? '') ?> = ?</label>
    <input id="cyber-register-captcha" type="text" name="captcha_answer" inputmode="numeric" autocomplete="off" required>

    <div class="esse-honeypot" aria-hidden="true" hidden>
        <label for="cyber-register-website">Website</label>
        <input type="text"
               id="cyber-register-website"
               name="<?= htmlspecialchars($data['honeypotField'] ?? '') ?>"
               tabindex="-1"
               autocomplete="off">
    </div>

    <button type="submit" class="cyber-btn cyber-auth-submit">Account erstellen</button>
</form>

<div class="cyber-auth-links">
    <a href="/login">Bereits registriert? Anmelden</a>
</div>
<?php endif ?>
