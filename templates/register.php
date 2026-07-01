<?php
/**
 * Content partial for /registrieren (auth.register.render hook).
 *
 * @var array $data
 */
$formData = $data['formData'] ?? [];
$pwPolicyCfg = $data['pwPolicyCfg'] ?? [];
$pwMode = $pwPolicyCfg['mode'] ?? null;
$pwMaxSequential = (int) ($pwPolicyCfg['maxSequential'] ?? 0);
$pwHistoryCount = (int) ($pwPolicyCfg['historyCount'] ?? 0);
$showSequentialCheck = $pwMode !== 'bsi' && $pwMaxSequential > 0;
?>
<?php if (empty($data['registrationEnabled'])): ?>
<div class="cyber-alert cyber-alert-info">Registrierung ist derzeit deaktiviert.</div>
<?php elseif (!empty($data['done'])): ?>
<div class="cyber-alert cyber-alert-success">
    Account erstellt! Wir haben dir eine E-Mail zur Bestätigung deiner Adresse gesendet.
    Bitte pruefe deinen Posteingang und klicke den Link, um dein Konto zu aktivieren.
</div>
<div class="cyber-auth-links">
    <a href="/login">Zurueck zum Login</a>
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

    <ul class="pw-strength cyber-pw-strength" data-target="cyber-register-password" data-config="cyber-register-password-policy">
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
    <script type="application/json" id="cyber-register-password-policy"><?= json_encode(
        $pwPolicyCfg,
        JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT
    ) ?></script>

    <label for="cyber-register-password-confirm">Passwort bestaetigen</label>
    <input id="cyber-register-password-confirm" type="password" name="password_confirm" autocomplete="new-password" required>

    <?php foreach (($data['customFields'] ?? []) as $field): ?>
    <?php
        $cfKey      = $field['field_key'];
        $cfId       = 'cyber-register-cf-' . $cfKey;
        $cfName     = 'cf_' . $cfKey;
        $cfRequired = (int) ($field['required'] ?? 0) === 1;
        $cfValue    = (string) ($formData[$cfKey] ?? '');
    ?>
    <?php if ($field['type'] === 'checkbox'): ?>
    <div class="cyber-field-checkbox">
        <input type="checkbox"
               id="<?= htmlspecialchars($cfId) ?>"
               name="<?= htmlspecialchars($cfName) ?>"
               value="1"
               <?= $cfValue === '1' ? 'checked' : '' ?>
               <?= $cfRequired ? 'required' : '' ?>>
        <label for="<?= htmlspecialchars($cfId) ?>">
            <?= htmlspecialchars($field['label']) ?><?php if ($cfRequired): ?> <span class="cyber-required-mark">*</span><?php endif ?>
        </label>
    </div>

    <?php elseif ($field['type'] === 'textarea'): ?>
    <label for="<?= htmlspecialchars($cfId) ?>">
        <?= htmlspecialchars($field['label']) ?><?php if ($cfRequired): ?> <span class="cyber-required-mark">*</span><?php endif ?>
    </label>
    <textarea id="<?= htmlspecialchars($cfId) ?>" name="<?= htmlspecialchars($cfName) ?>" rows="3" <?= $cfRequired ? 'required' : '' ?>><?= htmlspecialchars($cfValue) ?></textarea>

    <?php elseif ($field['type'] === 'select'): ?>
    <label for="<?= htmlspecialchars($cfId) ?>">
        <?= htmlspecialchars($field['label']) ?><?php if ($cfRequired): ?> <span class="cyber-required-mark">*</span><?php endif ?>
    </label>
    <select id="<?= htmlspecialchars($cfId) ?>" name="<?= htmlspecialchars($cfName) ?>" <?= $cfRequired ? 'required' : '' ?>>
        <option value="">— Bitte wählen —</option>
        <?php foreach (\Esse\UserFields::optionList($field) as $option): ?>
        <option value="<?= htmlspecialchars($option) ?>" <?= $option === $cfValue ? 'selected' : '' ?>><?= htmlspecialchars($option) ?></option>
        <?php endforeach ?>
    </select>

    <?php elseif ($field['type'] === 'date'): ?>
    <label for="<?= htmlspecialchars($cfId) ?>">
        <?= htmlspecialchars($field['label']) ?><?php if ($cfRequired): ?> <span class="cyber-required-mark">*</span><?php endif ?>
    </label>
    <input type="date" id="<?= htmlspecialchars($cfId) ?>" name="<?= htmlspecialchars($cfName) ?>" value="<?= htmlspecialchars($cfValue) ?>" <?= $cfRequired ? 'required' : '' ?>>

    <?php else: ?>
    <label for="<?= htmlspecialchars($cfId) ?>">
        <?= htmlspecialchars($field['label']) ?><?php if ($cfRequired): ?> <span class="cyber-required-mark">*</span><?php endif ?>
    </label>
    <input type="text" id="<?= htmlspecialchars($cfId) ?>" name="<?= htmlspecialchars($cfName) ?>" value="<?= htmlspecialchars($cfValue) ?>" <?= $cfRequired ? 'required' : '' ?>>
    <?php endif ?>
    <?php endforeach ?>

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
<script src="/public/assets/js/password-strength.js"></script>
<?php endif ?>
