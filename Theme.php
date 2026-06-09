<?php

declare(strict_types=1);

namespace EsseCyber;

use Esse\DB;
use Esse\Hooks;
use Esse\Menu;

class Theme extends \Esse\Theme
{
    private array $settings = [];

    public function boot(): void
    {
        $ts = DB::table('settings');
        $rows = DB::fetchAll("SELECT `key`, `value` FROM `{$ts}`");
        $this->settings = array_column($rows, 'value', 'key');

        Hooks::on('page.render', [$this, 'renderPage']);
        Hooks::on('auth.login.render', [$this, 'renderLogin']);
        Hooks::on('auth.forgot_password.render', [$this, 'renderForgotPassword']);
        Hooks::on('auth.reset_password.render', [$this, 'renderResetPassword']);
        Hooks::on('auth.register.render', [$this, 'renderRegister']);
    }

    public function renderPage(array $page, string $content): void
    {
        $vars = $this->layoutVars();
        $siteName = $vars['siteName'];
        $mainMenu = $vars['mainMenu'];
        $footMenu = $vars['footMenu'];
        $copyrightText = $vars['copyrightText'];
        $extraBodyHtml = '';
        $theme = $this;

        if (!empty($page['error_code'])) {
            require $this->basePath('templates/error.php');
            return;
        }

        require $this->basePath('templates/layout.php');
    }

    public function renderLogin(array $data): void
    {
        $content = $this->renderPartial('templates/login.php', ['data' => $data]);
        $extraBodyHtml = $this->passkeyScripts([
            'csrf' => $data['csrfToken'] ?? '',
            'redirect' => $data['redirect'] ?? '',
        ]);

        $this->renderContentPage([
            'slug' => 'login',
            'title' => 'Login',
            'icon' => 'fingerprint',
        ], $content, $extraBodyHtml);
    }

    public function renderForgotPassword(array $data): void
    {
        $content = $this->renderPartial('templates/forgot-password.php', ['data' => $data]);
        $this->renderContentPage([
            'slug' => 'admin/forgot-password',
            'title' => 'Passwort vergessen',
            'icon' => 'key',
        ], $content);
    }

    public function renderResetPassword(array $data): void
    {
        $content = $this->renderPartial('templates/reset-password.php', ['data' => $data]);
        $this->renderContentPage([
            'slug' => 'admin/reset-password',
            'title' => 'Neues Passwort',
            'icon' => 'shield-lock',
        ], $content);
    }

    public function renderRegister(array $data): void
    {
        $content = $this->renderPartial('templates/register.php', ['data' => $data]);
        $this->renderContentPage([
            'slug' => 'registrieren',
            'title' => 'Registrieren',
            'icon' => 'person-plus',
        ], $content);
    }

    public function renderIcon(?string $icon, string $class = ''): string
    {
        if (empty($icon)) {
            return '';
        }

        if (str_contains($icon, ' ')) {
            return '<i class="' . htmlspecialchars(trim($icon . ' ' . $class)) . '"></i>';
        }

        $iconHtml = \Esse\Ui::icon(preg_replace('/^(bi|ph|ti|lucide|ri)-/', '', $icon));
        return $class === '' ? $iconHtml : '<span class="' . htmlspecialchars($class) . '">' . $iconHtml . '</span>';
    }

    private function renderContentPage(array $page, string $content, string $extraBodyHtml = ''): void
    {
        $vars = $this->layoutVars();
        $siteName = $vars['siteName'];
        $mainMenu = $vars['mainMenu'];
        $footMenu = $vars['footMenu'];
        $copyrightText = $vars['copyrightText'];
        $theme = $this;

        require $this->basePath('templates/layout.php');
    }

    private function layoutVars(): array
    {
        $siteName = $this->settings['site_name'] ?? 'ESSE CMS';
        $mainSlug = $this->settings['theme_esse-cyber_menu_main']   ?? 'main';
        $footSlug = $this->settings['theme_esse-cyber_menu_footer']  ?? 'footer';
        $copyrightTemplate = trim($this->settings['theme_esse-cyber_copyright'] ?? '');
        $copyrightText = $copyrightTemplate !== ''
            ? strtr($copyrightTemplate, [
                '{year}' => date('Y'),
                '{site}' => $siteName,
            ])
            : '© ' . date('Y') . ' ' . $siteName;

        $mainMenu = Menu::get($mainSlug);
        $footMenu = $footSlug ? Menu::get($footSlug) : [];

        return [
            'siteName' => $siteName,
            'mainMenu' => $mainMenu,
            'footMenu' => $footMenu,
            'copyrightText' => $copyrightText,
        ];
    }

    private function renderPartial(string $template, array $vars = []): string
    {
        extract($vars, EXTR_SKIP);
        $theme = $this;

        ob_start();
        require $this->basePath($template);
        return (string) ob_get_clean();
    }

    private function passkeyScripts(array $config): string
    {
        return '<script type="application/json" id="passkey-login-config">'
            . json_encode($config, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT)
            . '</script>'
            . '<script src="/public/assets/js/webauthn.js"></script>'
            . '<script src="/public/assets/js/passkey-login.js"></script>';
    }
}
