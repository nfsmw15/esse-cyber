<?php
/**
 * @var array            $page
 * @var string           $content
 * @var string           $siteName
 * @var array            $mainMenu
 * @var array            $footMenu
 * @var string           $copyrightText
 * @var string           $extraBodyHtml
 * @var \EsseCyber\Theme  $theme
 */
$currentSlug = $page['slug'] ?? '';
$loginFailed = !empty($_GET['login_error']);
$renderIcon = [$theme, 'renderIcon'];
$extraBodyHtml = $extraBodyHtml ?? '';
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($page['title'] . ' // ' . $siteName) ?></title>
    <?php if (!empty($page['description'])): ?>
    <meta name="description" content="<?= htmlspecialchars($page['description']) ?>">
    <?php endif ?>
    <meta property="og:title"       content="<?= htmlspecialchars($page['title'] . ' // ' . $siteName) ?>">
    <meta property="og:type"        content="website">
    <meta property="og:url"         content="<?= htmlspecialchars('https://' . ($_SERVER['HTTP_HOST'] ?? '') . ($_SERVER['REQUEST_URI'] ?? '/')) ?>">
    <?php if (!empty($page['description'])): ?>
    <meta property="og:description" content="<?= htmlspecialchars($page['description']) ?>">
    <?php endif ?>
    <?= \Esse\Ui::iconPackCssTag() ?>
    <link rel="stylesheet" href="/public/vendor/esse-ui/esse-ui.css">
    <link rel="stylesheet" href="<?= $theme->assetUrl('css/esse-cyber.css') ?>">
</head>
<body>

<a href="#cyber-main" class="cyber-skip-link">Zum Inhalt springen</a>
<div class="cyber-scroll-progress" id="cyber-scroll-progress" aria-hidden="true"></div>

<div class="cyber-grid"></div>
<div class="cyber-glow"></div>
<div class="cyber-corner tl"></div>
<div class="cyber-corner tr"></div>
<div class="cyber-corner bl"></div>
<div class="cyber-corner br"></div>

<!-- Topbar -->
<nav class="cyber-topbar">
    <a href="/" class="cyber-logo"><?= htmlspecialchars(strtoupper($siteName)) ?></a>

    <div class="cyber-nav" id="cyber-nav">
        <button class="cyber-nav-close" id="cyber-nav-close" aria-label="Navigation schließen">✕</button>
        <?php foreach ($mainMenu as $itemIndex => $item):
            $url = \Esse\Menu::itemUrl($item);
            $isActive = $currentSlug === ltrim($url, '/');
        ?>
        <?php if (!empty($item['children'])): ?>
        <?php $navDropdownId = 'cyber-nav-dropdown-' . $itemIndex; ?>
        <div class="cyber-dropdown">
            <div class="cyber-dropdown-row">
                <a href="<?= htmlspecialchars($url) ?>" class="<?= $isActive ? 'active' : '' ?>">
                    <?= htmlspecialchars($item['label']) ?>
                </a>
                <button type="button"
                        class="cyber-dropdown-toggle"
                        aria-label="<?= htmlspecialchars($item['label']) ?> Untermenü öffnen"
                        aria-expanded="false"
                        aria-controls="<?= htmlspecialchars($navDropdownId) ?>">▾</button>
            </div>
            <div class="cyber-dropdown-menu" id="<?= htmlspecialchars($navDropdownId) ?>">
                <?php foreach ($item['children'] as $child): ?>
                <?php if ($child['type'] !== 'header'): ?>
                <a href="<?= htmlspecialchars(\Esse\Menu::itemUrl($child)) ?>"
                   <?= $child['target'] === '_blank' ? 'target="_blank" rel="noopener"' : '' ?>>
                    <?= htmlspecialchars($child['label']) ?>
                </a>
                <?php endif ?>
                <?php endforeach ?>
            </div>
        </div>
        <?php elseif ($item['type'] !== 'header'): ?>
        <a href="<?= htmlspecialchars($url) ?>"
           class="<?= $isActive ? 'active' : '' ?>"
           <?= $item['target'] === '_blank' ? 'target="_blank" rel="noopener"' : '' ?>>
            <?= htmlspecialchars($item['label']) ?>
        </a>
        <?php endif ?>
        <?php endforeach ?>
    </div>

    <div class="cyber-actions">
        <?php if (\Esse\Auth::check()): ?>
        <div class="cyber-user" id="cyber-user-toggle" tabindex="0" data-cyber-user-toggle>
            <span class="cyber-user-label">[ <?= htmlspecialchars(\Esse\Auth::user()['display_name'] ?? '') ?> ▾ ]</span>
            <div class="cyber-user-menu">
                <a href="/profil">// Profil</a>
                <?php if (\Esse\Auth::meetsRole('author')): ?>
                <a href="/admin">// Admin</a>
                <?php endif ?>
                <form method="post" action="/abmelden">
                    <input type="hidden" name="_csrf" value="<?= \Esse\Auth::csrfToken() ?>">
                    <button>// Abmelden</button>
                </form>
            </div>
        </div>
        <?php else: ?>
        <div class="cyber-user <?= $loginFailed ? 'open' : '' ?>" id="cyber-user-toggle" tabindex="0" data-cyber-user-toggle>
            <span class="cyber-user-label">[ Login ▾ ]</span>
            <div class="cyber-user-menu cyber-login-menu">
                <?php if ($loginFailed): ?>
                <div class="cyber-login-error">
                    // AUTH FAILED
                </div>
                <?php endif ?>
                <form id="navbar-login-form" class="cyber-login-form" method="post" action="/admin/login" <?= $loginFailed ? 'data-cyber-login-failed' : '' ?>>
                    <input type="hidden" name="_csrf"    value="<?= \Esse\Auth::csrfToken() ?>">
                    <input type="hidden" name="redirect" value="<?= htmlspecialchars($_SERVER['REQUEST_URI'] ?? '/') ?>">
                    <input type="email" name="login" placeholder="E-MAIL"
                           autocomplete="username" required>
                    <input type="password" name="password" placeholder="PASSWORD"
                           autocomplete="current-password" required
                           <?= $loginFailed ? 'autofocus' : '' ?>>
                    <button type="submit" class="cyber-btn cyber-login-submit">
                        // LOGIN
                    </button>
                </form>
                <a href="/admin/forgot-password" class="cyber-forgot-link">
                    forgot password
                </a>
                <a href="/login" class="cyber-forgot-link cyber-passkey-link">
                    <?= $renderIcon('fingerprint') ?> Mit Passkey anmelden
                </a>
            </div>
        </div>
        <?php endif ?>

        <div class="cyber-status">
            <div class="cyber-status-dot"></div>
            <span>ONLINE</span>
        </div>
    </div>
    <button class="cyber-menu-btn" id="cyber-menu-btn" aria-label="Navigation öffnen" aria-expanded="false">
        <span></span><span></span><span></span>
    </button>
</nav>

<!-- Content -->
<main class="cyber-main" id="cyber-main">
    <div class="cyber-main-inner">
        <?php if (!empty($page['title'])): ?>
        <h1 class="cyber-page-title">
            <?= $renderIcon($page['icon'] ?? null) ?>
            <?= htmlspecialchars($page['title']) ?>
        </h1>
        <?php endif ?>
        <div class="cyber-content-wrap">
            <div class="cyber-prose">
                <?= $content ?>
            </div>
        </div>
    </div>
</main>

<!-- Footer -->
<footer class="cyber-footer">
    <div class="cyber-clock" id="cyber-clock">--:--:--</div>
    <div class="cyber-copyright"><?= htmlspecialchars($copyrightText) ?></div>
    <?php if ($footMenu):
        $groups = [];
        $current = ['header' => null, 'links' => []];
        foreach ($footMenu as $item) {
            if ($item['type'] === 'header') {
                if ($current['header'] !== null || !empty($current['links'])) $groups[] = $current;
                $current = ['header' => $item['label'], 'links' => $item['children'] ?? []];
            } else {
                $current['links'][] = $item;
            }
        }
        if ($current['header'] !== null || !empty($current['links'])) $groups[] = $current;
    ?>
    <?php if ($groups): ?>
    <div class="cyber-footer-menu">
        <?php foreach ($groups as $groupIndex => $group): ?>
        <div class="cyber-footer-group">
            <?php $footerGroupId = 'cyber-footer-group-' . $groupIndex; ?>
            <button type="button"
                    class="cyber-footer-heading"
                    aria-expanded="false"
                    aria-controls="<?= htmlspecialchars($footerGroupId) ?>">
                <?= htmlspecialchars(strtoupper($group['header'] ?? 'MENÜ')) ?>
            </button>
            <div class="cyber-footer-items" id="<?= htmlspecialchars($footerGroupId) ?>">
            <?php foreach ($group['links'] as $link): ?>
            <?php if ($link['type'] === 'header'): ?>
                <div class="cyber-footer-note"><?= htmlspecialchars($link['label']) ?></div>
            <?php else: ?>
                <a href="<?= htmlspecialchars(\Esse\Menu::itemUrl($link)) ?>"
                   class="cyber-footer-link"
                   <?= $link['target'] === '_blank' ? 'target="_blank" rel="noopener"' : '' ?>>
                    <?= htmlspecialchars($link['label']) ?>
                </a>
            <?php endif ?>
            <?php endforeach ?>
            </div>
        </div>
        <?php endforeach ?>
    </div>
    <?php endif ?>
    <?php endif ?>
</footer>

<script src="<?= $theme->assetUrl('js/esse-cyber.js') ?>"></script>
<?= $extraBodyHtml ?>
</body>
</html>
