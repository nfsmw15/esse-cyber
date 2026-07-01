<?php
/**
 * Content partial for /admin/reset-password (auth.reset_password.render hook).
 *
 * @var array $data
 */
$pwPolicyCfg = $data['pwPolicyCfg'] ?? [];
$pwMode = $pwPolicyCfg['mode'] ?? null;
$pwMaxSequential = (int) ($pwPolicyCfg['maxSequential'] ?? 0);
$pwHistoryCount = (int) ($pwPolicyCfg['historyCount'] ?? 0);
$showSequentialCheck = $pwMode !== 'bsi' && $pwMaxSequential > 0;
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

    <ul class="pw-strength cyber-pw-strength" data-target="cyber-reset-password" data-config="cyber-reset-password-policy">
        <li data-check="length"><span class="pw-strength-mark">✗</span> <span class="pw-strength-text">Mindestens Zeichen</span></li>
        <li data-check="upper"><span class="pw-strength-mark">✗</span> <span class="pw-strength-text">Großbuchstaben</span></li>
        <li data-check="lower"><span class="pw-strength-mark">✗</span> <span class="pw-strength-text">Kleinbuchstaben</span></li>
        <li data-check="digit"><span class="pw-strength-mark">✗</span> <span class="pw-strength-text">Ziffern</span></li>
        <li data-check="special"><span class="pw-strength-mark">✗</span> <span class="pw-strength-text">Sonderzeichen</span></li>
        <?php if ($showSequentialCheck): ?>
        <li data-check="sequential"><span class="pw-strength-mark">✗</span> <span class="pw-strength-text">Keine langen Zeichenfolgen</span></li>
        <?php endif ?>
    </ul>
    <?php if ($pwMode !== 'bsi' && $pwHistoryCount > 0): ?>
    <div class="cyber-form-hint">Muss sich von den letzten <?= $pwHistoryCount ?> Passwörtern unterscheiden (wird beim Speichern geprüft).</div>
    <?php endif ?>
    <script type="application/json" id="cyber-reset-password-policy"><?= json_encode(
        $pwPolicyCfg,
        JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT
    ) ?></script>

    <label for="cyber-reset-password-confirm">Passwort bestaetigen</label>
    <input id="cyber-reset-password-confirm" type="password" name="password_confirm" autocomplete="new-password" required>

    <button type="submit" class="cyber-btn cyber-auth-submit">Passwort speichern</button>
</form>
<script src="/public/assets/js/password-strength.js"></script>
<?php endif ?>
