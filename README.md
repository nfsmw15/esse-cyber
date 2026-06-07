# esse-cyber

Cyberpunk-Terminal-Theme für ESSE CMS. Dunkler Hintergrund mit orangem Akzent, Scanlines-Overlay, animiertem Grid-Hintergrund und Monospace-Typografie.

[![Release](https://img.shields.io/github/v/release/nfsmw15/esse-cyber?label=release&color=blue)](https://github.com/nfsmw15/esse-cyber/releases)
[![License](https://img.shields.io/badge/license-AGPL--3.0-green)](LICENSE)
[![ESSE CMS](https://img.shields.io/badge/esse--cms-%3E%3D0.1.0-orange)](https://github.com/nfsmw15/esse-cms)

## Überblick

`esse-cyber` ist für öffentliche Content-Seiten gedacht — Portfolios, Projektseiten, kleine Blogs oder Community-Auftritte im Cyberpunk-Terminal-Look. Es bringt ein einziges, durchgängiges Layout für normale Seiten und Fehlerseiten mit:

- fixierte Topbar mit Logo, Hauptnavigation (inkl. Dropdown), User-/Login-Menü und Status-Anzeige
- Hintergrund-Ebenen mit Scanlines, animiertem Grid, Glow-Effekt und Eck-Dekorationen
- zentrierter Content-Bereich mit Glasmorphism-Panel, Scroll-Fortschrittsbalken und automatisch formatierter Prosa
- fixierter Footer als HUD-Balken mit Live-Uhr, konfigurierbarem Copyright und gruppierbarer Footer-Navigation
- vollständige mobile Navigation als Fullscreen-Overlay mit Hamburger-Button und aufklappbaren Footer-Gruppen
- ESSE-UI-Komponenten-Support für Plugin-Ausgaben

Es gibt keinen Dashboard- oder Mitgliederbereich und keinen Light/Dark-Umschalter — das Theme ist bewusst auf einen einzigen, dunklen Cyberpunk-Stil zugeschnitten.

## Voraussetzungen

- ESSE CMS mit aktivem Plugin-System
- ESSE UI: `/public/vendor/esse-ui/esse-ui.css`

## Installation

Theme-Verzeichnis nach `themes/esse-cyber/` im ESSE-CMS-Root kopieren. Das Theme wird automatisch erkannt, sobald `theme.json` und `Theme.php` vorhanden sind.

```text
themes/
└── esse-cyber/
    ├── theme.json
    ├── Theme.php
    ├── README.md
    ├── CHANGELOG.md
    ├── LICENSE
    ├── assets/
    │   ├── css/
    │   │   └── esse-cyber.css
    │   └── fonts/
    │       ├── rajdhani-400.woff2
    │       ├── rajdhani-700.woff2
    │       └── share-tech-mono.woff2
    └── templates/
        ├── layout.php
        └── error.php
```

Danach kann das Theme im ESSE-Admin unter **Themes** aktiviert werden.

## Manifest

`theme.json`:

```json
{
    "name": "esse-cyber",
    "version": "0.5.6",
    "description": "Cyberpunk terminal theme with scanlines, grid background and orange accent.",
    "author": "ESSE CMS",
    "class": "EsseCyber\\Theme",
    "menus": {
        "main":   "Hauptnavigation",
        "footer": "Footer-Links"
    }
}
```

Wichtig für ESSE CMS:

- `name` muss dem Theme-Verzeichnis entsprechen: `esse-cyber`.
- `class` muss auf die Theme-Klasse zeigen: `EsseCyber\Theme`.
- Das GitHub-Repository muss für die CMS-Discovery das Topic `esse-theme` besitzen.
- Veröffentlichte Versionen werden über GitHub Releases gefunden.

### Theme.php — Boot-Prozess

`boot()` lädt einmalig pro Request alle CMS-Settings in `$this->settings` und registriert `renderPage()` auf dem Hook `page.render`.

`renderPage(array $page, string $content)`:

1. liest `site_name` sowie die Menü-Slugs (`theme_esse-cyber_menu_main` / `_footer`) aus den Settings
2. baut `$copyrightText` aus dem Setting `theme_esse-cyber_copyright` auf — Platzhalter `{year}` und `{site}`, Fallback `© {Jahr} {Site-Name}` wenn das Setting leer ist
3. lädt die Menü-Arrays per `Menu::get()`
4. inkludiert je nach `$page['error_code']` entweder `templates/error.php` oder `templates/layout.php`

## Menüs

Das Theme deklariert zwei Menü-Slots.

| Slot | Settings-Key | Fallback-Slug | Zweck |
|---|---|---|---|
| `main` | `theme_esse-cyber_menu_main` | `main` | Topbar-Hauptnavigation (unterstützt ein Dropdown-Level) |
| `footer` | `theme_esse-cyber_menu_footer` | `footer` | Footer-Links, gruppierbar mit Header-Einträgen |

Weitere Settings:

| Settings-Key | Zweck |
|---|---|
| `theme_esse-cyber_copyright` | Copyright-Text-Vorlage mit Platzhaltern `{year}` und `{site}`; leer = Fallback `© {Jahr} {Site-Name}` |

## Templates / Rendering-Logik

Die Auswahl des Templates passiert in `Theme.php`.

| Zustand | Template | Verhalten |
|---|---|---|
| `error_code` gesetzt | `templates/error.php` | Minimales Fehlerlayout (404, 403 …) ohne Navigation |
| Normale Seite | `templates/layout.php` | Vollständiges Layout mit Topbar, Content und Footer |

### layout.php

Erwartet folgende Variablen:

| Variable | Typ | Beschreibung |
|---|---|---|
| `$page` | `array` | Seiten-Daten aus dem CMS |
| `$content` | `string` | Gerenderter Seiteninhalt (HTML) |
| `$siteName` | `string` | Name der Website |
| `$mainMenu` | `array` | Items des Hauptmenüs |
| `$footMenu` | `array` | Items des Footer-Menüs |
| `$copyrightText` | `string` | Fertig aufgelöster Copyright-Text (siehe Theme.php) |
| `$theme` | `\EsseCyber\Theme` | Theme-Instanz (für `assetUrl()` etc.) |

Aufbau:

1. Skip-to-content-Link, Scroll-Fortschrittsbalken und Hintergrund-Ebenen (`cyber-grid`, `cyber-glow`, vier `cyber-corner`-Dekors)
2. Fixierte Topbar mit Logo, Navigation, User-/Login-Menü, Status-Anzeige und Hamburger-Button
3. `<main>` mit Seiten-Titel und `cyber-content-wrap`
4. Fixierter Footer mit Live-Uhr, Copyright und Footer-Navigation

Im `<head>` werden zusätzlich automatisch gesetzt:

| Tag | Quelle |
|---|---|
| `og:title` | `$page['title'] // $siteName` |
| `og:type` | `website` (fest) |
| `og:url` | `HTTP_HOST` + `REQUEST_URI` |
| `og:description` | `$page['description']` (nur wenn gesetzt) |
| `meta[name=description]` | `$page['description']` (nur wenn gesetzt) |

### error.php

Minimales Layout für Fehlerseiten (ohne Navigation). Zeigt Fehlercode, Titel und Meldung sowie Links zurück zur Startseite und per `history.back()`.

Erwartet: `$page['error_code']`, `$page['error_title']`, `$page['error_message']`, `$siteName`, `$theme`.

## Design-Tokens (CSS Custom Properties)

Alle Farben und Schriften sind über Custom Properties definiert und können in Child-Styles überschrieben werden.

| Variable | Wert | Verwendung |
|---|---|---|
| `--bg` | `#050508` | Seitenhintergrund |
| `--surface` | `#0d0d14` | Karten, Dropdown-Hintergründe |
| `--border` | `rgba(255,255,255,0.06)` | Rahmenlinien |
| `--accent` | `#e8640a` | Akzentfarbe (Orange) |
| `--accent2` | `#ff9d45` | Hover-Akzent (helleres Orange) |
| `--text` | `#e8e6e0` | Fließtext |
| `--muted` | `#9a9aa8` | Sekundärer Text, Metadaten |
| `--mono` | `'Share Tech Mono', monospace` | Monospace-Schrift (UI-Labels) |
| `--head` | `'Rajdhani', sans-serif` | Überschriften & Fließtext |

Zusätzlich setzt das Theme die `--esse-*` Variablen für die CMS-UI-Komponenten (`esse-panel`, `esse-btn`, `esse-alert`, `esse-table`, `esse-tabs` usw.), damit Plugin-Ausgaben in der Cyber-Optik erscheinen.

### Schriften

Alle Schriften werden lokal aus `assets/fonts/` geladen, kein CDN erforderlich.

| Schriftart | Gewichte | Verwendung |
|---|---|---|
| Rajdhani | 400, 700 | Überschriften, Fließtext, Akzent-Fettungen |
| Share Tech Mono | 400 | UI-Labels, Code |

## esse-grid Support

Das Theme implementiert die verpflichtenden Grid-Klassen für Plugins:

```html
<div class="esse-grid-wrap">
    <div class="esse-grid" data-cols="3">
        <div class="esse-grid-item">Inhalt</div>
        <div class="esse-grid-item">Inhalt</div>
        <div class="esse-grid-item">Inhalt</div>
    </div>
</div>
```

| `data-cols` | Spalten Desktop | Tablet (≤768px) | Mobil (≤480px) |
|---|---|---|---|
| `2` | 2 | 2 | 2 |
| `3` | 3 | 2 | 2 |
| `4` | 4 | 2 | 2 |
| `6` | 6 | 3 | 2 |

## ESSE-UI-Integration

Das Theme lädt `/public/vendor/esse-ui/esse-ui.css` und überschreibt die `esse-*` Komponenten über `assets/css/esse-cyber.css`.

```css
.esse-panel,
.esse-btn,
.esse-alert,
.esse-badge,
.esse-table,
.esse-tabs-btn,
.esse-pagination,
.esse-empty-state { ... }
```

Innerhalb von `.cyber-content-wrap` (gerenderter Seiteninhalt) erhalten alle gängigen esse-ui-Komponenten den vollen Cyber-Stil. Für Plugin-Seiten **außerhalb** des Content-Wrappers (z. B. eigene Plugin-Templates) gibt es globale Fallbacks für `.esse-btn--primary` und `.esse-table tbody tr:hover`, damit auch dort kein unstimmiger Bootstrap-Look durchscheint.

Zusätzlich werden Bootstrap-Badge-Klassen (`badge.bg-*`/`text-bg-*`) sowie die Gallery-Plugin-Badges (`gal-badge-*`) auf den Cyber-Stil überschrieben, da einzelne Plugins noch eigene Badge-Markups ausgeben.

## CSS-Komponenten

### Topbar & Navigation

```
.cyber-topbar          Fixierte Navigationsleiste oben
.cyber-logo            Site-Logo-Link (Monospace, Orange)
.cyber-nav             Navigations-Container (zentriert; mobil: Fullscreen-Overlay)
.cyber-nav a           Navigationspunkt (Uppercase, Border-Separator)
.cyber-nav a.active    Aktiver Navigationspunkt
.cyber-dropdown        Dropdown-Wrapper (ein Level, öffnet per :hover/:focus-within)
.cyber-dropdown-toggle Mobiler Auf-/Zuklapp-Button für Dropdown-Untermenüs
.cyber-menu-btn        Hamburger-Button (nur ≤768px sichtbar, .open animiert zu ✕)
.cyber-nav-close       Schließen-Button innerhalb des Nav-Overlays
.cyber-scroll-progress Fortschrittsbalken am oberen Rand (Scrollposition)
```

Auf mobilen Viewports (≤768px) wird `.cyber-nav` zu einem fullscreen-Overlay (`position: fixed`, `z-index: 490`). Dropdowns klappen über `.cyber-dropdown-toggle` inline auf statt als Hover-Menü. Schließt per `Escape`, ✕-Button oder Klick auf den Hintergrund.

### User-Menu & Status

```
.cyber-actions      Wrapper für User-Menu und Status in der Topbar
.cyber-user         Toggle-Button (Klick togglet .open)
.cyber-user-label   Sichtbarer Beschriftungstext des Toggles
.cyber-user-menu    Dropdown (sichtbar wenn .open / :focus-within)
.cyber-forgot-link  „Passwort vergessen“-Link im Login-Dropdown
.cyber-status       „ONLINE“-Label mit blinkendem Dot (mobil ausgeblendet)
.cyber-status-dot   Grüner Dot (Blink-Animation, 2 s)
```

Das Menü öffnet/schließt sich per Klick oder Tastatur (`Enter`/Leertaste) auf `#cyber-user-toggle`. Klicks außerhalb schließen es; nach fehlgeschlagenem Navbar-Login bleibt es offen und fokussiert das Passwortfeld.

### Skip-to-content

```
.cyber-skip-link    Visuell versteckt, bei :focus sichtbar (orangener Balken oben links)
```

Springt zu `#cyber-main`. Erscheint nur bei Tastaturnavigation.

### Hintergrund-Effekte

```
.cyber-grid         Fixes Raster-Muster (60×60 px, orange-transparent)
.cyber-glow         Radialer Glow-Kreis oben, animiert (pulse 6 s)
.cyber-corner       Eck-Dekorationen (tl/tr/bl/br)
body::before        Scanlines-Overlay (repeating-linear-gradient)
```

### Content-Bereich

```
.cyber-main          Zentrierender Wrapper (min-height 100vh; mobil aufgehoben)
.cyber-page-title    Seiten-Titel (fügt '// ' vor dem Titel ein)
.cyber-content-wrap  Panel mit Glasmorphism-Hintergrund, fadeUp-Animation
.cyber-prose         Typografie-Wrapper für CMS-Inhalte
```

#### Prose-Stile (`cyber-prose`)

Formatiert CMS-Content automatisch:

- `h2` erhält ein vorangestelltes `// ` in Akzentfarbe
- `code` → orange, halbtransparenter Hintergrund
- `pre` → Surface-Hintergrund, linker Akzentrahmen
- `blockquote` → linker Akzentrahmen, gedämpfte Farbe
- `table` → Monospace-Header in Orange, Border-Kollaps
- `figure`/`figcaption` → gerahmte Medienfläche mit `// `-Präfix-Caption

### Footer

```
.cyber-footer        Fixierter Footer unten (mobil: statisch, gestapelt)
.cyber-clock         Live-Uhr (#cyber-clock, per JS aktualisiert), links
.cyber-copyright     Konfigurierbarer Copyright-Hinweis, zentriert
.cyber-footer-menu   Rechts verankerte Footer-Menügruppen im HUD-Balken
.cyber-footer-group  Einzelne Menügruppe
.cyber-footer-heading Gruppenüberschrift (mobil: Akkordeon-Button)
.cyber-footer-items  Linkliste einer Gruppe (mobil: ein-/ausklappbar)
.cyber-footer-link   Einzel-Link im Footer-Menü
```

Auf mobilen Viewports werden Footer-Gruppen zu Akkordeons: `.cyber-footer-heading` ist dort ein Button, der `.cyber-footer-items` ein-/ausklappt; auf dem Desktop bleibt alles permanent sichtbar.

### Buttons & Fehlerseite

```
.cyber-btn          Monospace-Button/Link mit Akzent-Rahmen
.cyber-error        Fehlerseiten-Wrapper (zentriert)
.cyber-error-code   Großer Fehlercode
.cyber-error-title  Titel-Zeile (// PREFIX)
.cyber-error-msg    Meldungstext
.cyber-error-links  Link-Container (.cyber-btn)
```

## Entwicklung / Deployment

PHP-Syntax prüfen:

```bash
php -l Theme.php
php -l templates/layout.php
php -l templates/error.php
```

Für ein manuelles Deployment müssen mindestens diese Dateien übertragen werden, wenn Layout oder Styles geändert wurden:

```text
assets/css/esse-cyber.css
templates/layout.php
templates/error.php
```

Der produktive Pfad hängt von der jeweiligen ESSE-CMS-Installation ab.

## Changelog

Siehe [CHANGELOG.md](CHANGELOG.md).

## Lizenz

AGPL-3.0 — siehe [LICENSE](LICENSE).
