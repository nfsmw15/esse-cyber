<?php
/**
 * @var array            $page
 * @var string           $content
 * @var string           $siteName
 * @var array            $mainMenu
 * @var array            $footMenu
 * @var \EsseCyber\Theme  $theme
 */
$currentSlug = $page['slug'] ?? '';
$loginFailed = !empty($_GET['login_error']);
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($page['title'] . ' // ' . $siteName) ?></title>
    <link rel="stylesheet" href="/public/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= $theme->assetUrl('css/esse-cyber.css') ?>">
</head>
<body>

<div class="cyber-grid"></div>
<div class="cyber-glow"></div>
<div class="cyber-corner tl"></div>
<div class="cyber-corner tr"></div>
<div class="cyber-corner bl"></div>
<div class="cyber-corner br"></div>

<!-- Topbar -->
<nav class="cyber-topbar">
    <a href="/" class="cyber-logo"><?= htmlspecialchars(strtoupper($siteName)) ?></a>

    <div class="cyber-nav">
        <?php foreach ($mainMenu as $item):
            $url = \Esse\Menu::itemUrl($item);
            $isActive = $currentSlug === ltrim($url, '/');
        ?>
        <?php if (!empty($item['children'])): ?>
        <div class="cyber-dropdown">
            <a href="<?= htmlspecialchars($url) ?>" class="<?= $isActive ? 'active' : '' ?>">
                <?= htmlspecialchars($item['label']) ?> ▾
            </a>
            <div class="cyber-dropdown-menu">
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

    <div style="display:flex;align-items:center;gap:1rem">
        <?php if (\Esse\Auth::check()): ?>
        <div class="cyber-user" id="cyber-user-toggle" tabindex="0" onclick="event.stopPropagation();this.classList.toggle('open')" style="user-select:none">
            [ <?= htmlspecialchars(\Esse\Auth::user()['display_name'] ?? '') ?> ▾ ]
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
        <div class="cyber-user <?= $loginFailed ? 'open' : '' ?>" id="cyber-user-toggle" tabindex="0" onclick="event.stopPropagation();this.classList.toggle('open')" style="user-select:none">
            [ Login ▾ ]
            <div class="cyber-user-menu" style="min-width:220px;padding:.75rem">
                <?php if ($loginFailed): ?>
                <div style="font-family:var(--mono);font-size:.8rem;color:#f87171;padding:.25rem .5rem .75rem;border-bottom:1px solid var(--border);margin-bottom:.5rem">
                    // AUTH FAILED
                </div>
                <?php endif ?>
                <form id="navbar-login-form" method="post" action="/admin/login" style="display:flex;flex-direction:column;gap:.5rem;padding:.25rem">
                    <input type="hidden" name="_csrf"    value="<?= \Esse\Auth::csrfToken() ?>">
                    <input type="hidden" name="redirect" value="<?= htmlspecialchars($_SERVER['REQUEST_URI'] ?? '/') ?>">
                    <input type="email" name="login" placeholder="E-MAIL"
                           autocomplete="username" required
                           style="background:var(--bg);border:1px solid var(--border);color:var(--text);font-family:var(--mono);font-size:.85rem;padding:.4rem .6rem;letter-spacing:.05em;width:100%">
                    <input type="password" name="password" placeholder="PASSWORD"
                           autocomplete="current-password" required
                           <?= $loginFailed ? 'autofocus' : '' ?>
                           style="background:var(--bg);border:1px solid var(--border);color:var(--text);font-family:var(--mono);font-size:.85rem;padding:.4rem .6rem;letter-spacing:.05em;width:100%">
                    <button type="submit" class="cyber-btn" style="text-align:center;cursor:pointer;background:none">
                        // LOGIN
                    </button>
                </form>
                <a href="/admin/forgot-password" style="display:block;text-align:center;padding:.25rem;font-family:var(--mono);font-size:.8rem;color:var(--muted);text-decoration:none">
                    forgot password
                </a>
            </div>
        </div>
        <?php endif ?>

        <div class="cyber-status">
            <div class="cyber-status-dot"></div>
            <span>ONLINE</span>
        </div>
    </div>
</nav>

<!-- Content -->
<main class="cyber-main">
    <div style="width:100%;max-width:860px">
        <?php if (!empty($page['title'])): ?>
        <h1 class="cyber-page-title">
            <?php if (!empty($page['icon'])): ?><i class="<?= htmlspecialchars($page['icon']) ?>"></i><?php endif ?>
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
        <?php foreach ($groups as $group): ?>
        <div class="cyber-footer-group">
            <?php if ($group['header'] !== null): ?>
            <div class="cyber-footer-heading"><?= htmlspecialchars(strtoupper($group['header'])) ?></div>
            <?php endif ?>
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
        <?php endforeach ?>
    </div>
    <?php endif ?>
    <?php endif ?>
</footer>

<script src="/public/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script>
(function() {
    function tick() {
        const n = new Date(), p = n => String(n).padStart(2,'0');
        document.getElementById('cyber-clock').textContent =
            p(n.getHours())+':'+p(n.getMinutes())+':'+p(n.getSeconds());
    }
    tick();
    setInterval(tick, 1000);

    // Close user menu when clicking outside
    document.addEventListener('click', function() {
        document.getElementById('cyber-user-toggle')?.classList.remove('open');
    });

    // Prevent form clicks inside menu from closing it
    document.querySelector('.cyber-user-menu')?.addEventListener('click', function(e) {
        e.stopPropagation();
    });

    document.getElementById('cyber-user-toggle')?.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            this.classList.toggle('open');
        }
    });

    <?php if ($loginFailed): ?>
    document.querySelector('#navbar-login-form input[name="password"]')?.focus();
    <?php endif ?>
})();
</script>
</body>
</html>
