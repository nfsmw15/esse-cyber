<?php
/**
 * Content partial for /email-bestaetigen (auth.verify_email.render hook).
 *
 * @var array $data
 */
?>
<?php if (!empty($data['verifiedNow']) && !empty($data['pendingApprovalAfterVerify'])): ?>
<div class="cyber-alert cyber-alert-success">
    E-Mail-Adresse bestaetigt! Dein Account wartet jetzt zusaetzlich auf Freigabe durch einen
    Administrator. Du wirst per E-Mail informiert, sobald du dich einloggen kannst.
</div>

<?php elseif (!empty($data['verifiedNow'])): ?>
<div class="cyber-alert cyber-alert-success">
    E-Mail-Adresse bestaetigt! Du kannst dich jetzt anmelden.
</div>
<a href="/login" class="cyber-btn cyber-auth-submit">Zum Login</a>

<?php else: ?>

<?php if (!empty($data['tokenInvalid'])): ?>
<div class="cyber-alert cyber-alert-danger">
    Dieser Link ist ungueltig oder abgelaufen.
</div>
<?php endif ?>

<?php if (!empty($data['sent'])): ?>
<div class="cyber-alert cyber-alert-success">
    Falls ein unbestaetigtes Konto mit dieser E-Mail-Adresse existiert, wurde eine neue
    Bestaetigungs-Mail versendet. Bitte pruefe deinen Posteingang.
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
    Gib deine E-Mail-Adresse ein. Falls dein Konto noch unbestaetigt ist, erhaeltst du einen neuen Bestaetigungs-Link.
</p>

<form method="post" action="/email-bestaetigen" class="cyber-auth-form cyber-auth-narrow">
    <input type="hidden" name="_csrf" value="<?= htmlspecialchars($data['csrfToken'] ?? '') ?>">

    <label for="cyber-verify-email">E-Mail</label>
    <input id="cyber-verify-email"
           type="email"
           name="email"
           autocomplete="username"
           value="<?= htmlspecialchars($data['prefillEmail'] ?? '') ?>"
           autofocus
           required>

    <label for="cyber-verify-captcha"><?= htmlspecialchars($data['captchaQuestion'] ?? '') ?> = ?</label>
    <input id="cyber-verify-captcha" type="text" name="captcha_answer" inputmode="numeric" autocomplete="off" required>

    <div class="esse-honeypot" aria-hidden="true" hidden>
        <label for="cyber-verify-website">Website</label>
        <input type="text"
               id="cyber-verify-website"
               name="<?= htmlspecialchars($data['honeypotField'] ?? '') ?>"
               tabindex="-1"
               autocomplete="off">
    </div>

    <button type="submit" class="cyber-btn cyber-auth-submit">Bestaetigungs-Mail senden</button>
</form>

<div class="cyber-auth-links">
    <a href="/login">Zurueck zum Login</a>
</div>
<?php endif ?>
<?php endif ?>
