<?php
/**
 * Content partial for /admin/forgot-password.
 *
 * @var array $data
 */
?>
<?php if (!empty($data['sent'])): ?>
<div class="cyber-alert cyber-alert-success">
    Falls ein Account mit dieser E-Mail-Adresse existiert, wurde ein Reset-Link versendet.
    Bitte pruefe deinen Posteingang.
</div>
<a href="/login" class="cyber-btn cyber-auth-submit">Zurueck zum Login</a>
<?php else: ?>

<?php if (!empty($data['errors'])): ?>
<div class="cyber-alert cyber-alert-danger">
    <?php foreach ($data['errors'] as $error): ?>
    <div><?= htmlspecialchars($error) ?></div>
    <?php endforeach ?>
</div>
<?php endif ?>

<p class="cyber-auth-copy cyber-auth-narrow">
    Gib deine E-Mail-Adresse ein. Du erhaeltst einen Link zum Zuruecksetzen deines Passworts.
</p>

<form method="post" action="/admin/forgot-password" class="cyber-auth-form cyber-auth-narrow">
    <input type="hidden" name="_csrf" value="<?= htmlspecialchars($data['csrfToken'] ?? '') ?>">

    <label for="cyber-forgot-email">E-Mail</label>
    <input id="cyber-forgot-email" type="email" name="email" autocomplete="username" autofocus required>

    <label for="cyber-forgot-captcha"><?= htmlspecialchars($data['captchaQuestion'] ?? '') ?> = ?</label>
    <input id="cyber-forgot-captcha" type="text" name="captcha_answer" inputmode="numeric" autocomplete="off" required>

    <div class="esse-honeypot" aria-hidden="true" hidden>
        <label for="cyber-forgot-website">Website</label>
        <input type="text"
               id="cyber-forgot-website"
               name="<?= htmlspecialchars($data['honeypotField'] ?? '') ?>"
               tabindex="-1"
               autocomplete="off">
    </div>

    <button type="submit" class="cyber-btn cyber-auth-submit">Link senden</button>
</form>

<div class="cyber-auth-links">
    <a href="/login">Zurueck zum Login</a>
</div>
<?php endif ?>
