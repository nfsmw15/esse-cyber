<?php
/**
 * Content partial for /admin/reset-password.
 *
 * @var array $data
 */
?>
<?php if (!empty($data['success'])): ?>
<div class="cyber-alert cyber-alert-success">
    Passwort erfolgreich geaendert. Du kannst dich jetzt anmelden.
</div>
<a href="/login" class="cyber-btn cyber-auth-submit">Zum Login</a>

<?php elseif (empty($data['valid'])): ?>
<div class="cyber-alert cyber-alert-danger">
    Dieser Link ist ungueltig oder abgelaufen.
</div>
<a href="/admin/forgot-password" class="cyber-btn cyber-auth-submit">Neuen Link anfordern</a>

<?php else: ?>

<?php if (!empty($data['errors'])): ?>
<div class="cyber-alert cyber-alert-danger">
    <?php foreach ($data['errors'] as $error): ?>
    <div><?= htmlspecialchars($error) ?></div>
    <?php endforeach ?>
</div>
<?php endif ?>

<form method="post" action="/admin/reset-password" class="cyber-auth-form">
    <input type="hidden" name="_csrf" value="<?= htmlspecialchars($data['csrfToken'] ?? '') ?>">
    <input type="hidden" name="token" value="<?= htmlspecialchars($data['token'] ?? '') ?>">

    <label for="cyber-reset-password">Neues Passwort</label>
    <input id="cyber-reset-password" type="password" name="password" autocomplete="new-password" autofocus required>
    <div class="cyber-form-hint">Mindestens 10 Zeichen</div>

    <label for="cyber-reset-password-confirm">Passwort bestaetigen</label>
    <input id="cyber-reset-password-confirm" type="password" name="password_confirm" autocomplete="new-password" required>

    <button type="submit" class="cyber-btn cyber-auth-submit">Passwort speichern</button>
</form>
<?php endif ?>
