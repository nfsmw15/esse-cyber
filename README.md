# esse-cyber

Cyberpunk-Terminal-Theme für ESSE CMS. Dunkler Hintergrund mit orangem Akzent, Scanlines-Overlay, animiertem Grid-Hintergrund und Monospace-Typografie.

## Voraussetzungen

- ESSE CMS mit aktivem Plugin-System
- ESSE UI (wird über `/public/vendor/esse-ui/esse-ui.css` eingebunden)

## Installation

Theme-Verzeichnis nach `themes/esse-cyber/` im ESSE-CMS-Root kopieren. Das Theme wird automatisch erkannt, sobald `theme.json` und `Theme.php` vorhanden sind.

## Verzeichnisstruktur

```
esse-cyber/
├── assets/
│   ├── css/
│   │   └── esse-cyber.css      # Gesamtes Stylesheet
│   └── fonts/
│       ├── rajdhani-400.woff2
│       └── share-tech-mono.woff2
├── templates/
│   ├── layout.php              # Standard-Seiten-Layout
│   └── error.php               # Fehlerseiten (404, 500 etc.)
├── theme.json                  # Theme-Metadaten & Menü-Slots
└── Theme.php                   # Boot-Logik, Hook-Registrierung
```

## Konfiguration

### theme.json

```json
{
    "name": "esse-cyber",
    "version": "0.5.2",
    "description": "Cyberpunk terminal theme with scanlines, grid background and orange accent.",
    "author": "ESSE CMS",
    "class": "EsseCyber\\Theme",
    "menus": {
        "main":   "Hauptnavigation",
        "footer": "Footer-Links"
    }
}
```

### Menü-Slots

| Slot     | Beschreibung                                         |
|----------|------------------------------------------------------|
| `main`   | Topbar-Navigation (unterstützt ein Dropdown-Level)   |
| `footer` | Footer-Links, gruppierbar mit Header-Einträgen       |

Die Menü-Slugs werden über die CMS-Settings gespeichert:
- `theme_esse-cyber_menu_main` → Slug des Hauptmenüs (Standard: `main`)
- `theme_esse-cyber_menu_footer` → Slug des Footer-Menüs (Standard: `footer`)

## Design-Tokens (CSS Custom Properties)

Alle Farben und Schriften sind über Custom Properties definiert und können in Child-Styles überschrieben werden.

| Variable    | Wert                       | Verwendung                       |
|-------------|----------------------------|----------------------------------|
| `--bg`      | `#050508`                  | Seitenhintergrund                |
| `--surface` | `#0d0d14`                  | Karten, Dropdown-Hintergründe    |
| `--border`  | `rgba(255,255,255,0.06)`   | Rahmenlinien                     |
| `--accent`  | `#e8640a`                  | Akzentfarbe (Orange)             |
| `--accent2` | `#ff9d45`                  | Hover-Akzent (helleres Orange)   |
| `--text`    | `#e8e6e0`                  | Fließtext                        |
| `--muted`   | `#9a9aa8`                  | Sekundärer Text, Metadaten       |
| `--mono`    | `'Share Tech Mono', monospace` | Monospace-Schrift (UI-Labels) |
| `--head`    | `'Rajdhani', sans-serif`   | Überschriften & Fließtext        |

Zusätzlich setzt das Theme die `--esse-*` Variablen für die CMS-UI-Komponenten (`esse-panel`, `esse-btn`, `esse-alert`, `esse-table`, `esse-tabs` usw.), damit Plugin-Ausgaben in der Cyber-Optik erscheinen.

## Schriften

Alle Schriften werden lokal aus `assets/fonts/` geladen, kein CDN erforderlich.

| Schriftart       | Gewichte    | Verwendung           |
|------------------|-------------|----------------------|
| Rajdhani         | 400         | Überschriften, Text; Fettungen werden per CSS synthetisiert |
| Share Tech Mono  | 400         | UI-Labels, Code      |

## Templates

### layout.php

Vollständiges HTML-Dokument für normale Seiten. Erwartet folgende Variablen:

| Variable    | Typ                  | Beschreibung                          |
|-------------|----------------------|---------------------------------------|
| `$page`     | `array`              | Seiten-Daten aus dem CMS              |
| `$content`  | `string`             | Gerendeter Seiteninhalt (HTML)        |
| `$siteName` | `string`             | Name der Website                      |
| `$mainMenu` | `array`              | Items des Hauptmenüs                  |
| `$footMenu` | `array`              | Items des Footer-Menüs                |
| `$theme`    | `\EsseCyber\Theme`   | Theme-Instanz (für `assetUrl()` etc.) |

Aufbau:
1. Fixierter Topbar mit Logo, Navigation, User-Menu und Status-Dot
2. Hintergrund-Ebenen: `cyber-grid`, `cyber-glow`, vier `cyber-corner`-Dekors
3. `<main>` mit Seiten-Titel und `cyber-content-wrap`
4. Fixierter Footer mit Live-Uhr und Footer-Navigation

### error.php

Minimales Layout für Fehlerseiten (ohne Navigation). Zeigt Fehlercode, Titel und Meldung sowie Links zurück zur Startseite und per `history.back()`.

Erwartet: `$page['error_code']`, `$page['error_title']`, `$page['error_message']`, `$siteName`, `$theme`.

## CSS-Komponenten

### Topbar

```
.cyber-topbar       Fixierte Navigationsleiste oben
.cyber-logo         Site-Logo-Link (Monospace, Orange)
.cyber-nav          Navigations-Container (zentriert)
.cyber-nav a        Navigationspunkt (Uppercase, Border-Separator)
.cyber-nav a.active Aktiver Navigationspunkt
```

#### Dropdown (ein Level)

```html
<div class="cyber-dropdown">
    <a href="/parent">Elternpunkt ▾</a>
    <div class="cyber-dropdown-menu">
        <a href="/child">Unterpunkt</a>
    </div>
</div>
```

Das Dropdown öffnet sich per CSS-`:hover` und `:focus-within` ohne JavaScript.

### Skip-to-content

```
.cyber-skip-link    Visuell versteckt, bei :focus sichtbar (orangener Balken oben links)
```

Springt zu `#cyber-main`. Taucht nur auf wenn per Tastatur navigiert wird.

### Mobile Navigation

```
.cyber-menu-btn     Hamburger-Button (nur ≤768px sichtbar, .open animiert zu ✕)
.cyber-nav-close    Schließen-Button innerhalb des Nav-Overlays
```

Auf mobilen Viewports (≤768px) wird `.cyber-nav` zu einem fullscreen-Overlay (`position: fixed, z-index: 490`). Dropdowns expandieren inline statt als Hover-Menü. Schließt per `Escape`, ✕-Button oder Klick auf den Hintergrund.

### User-Menu

```
.cyber-user         Toggle-Button (click-toggles .open)
.cyber-user-menu    Dropdown (sichtbar wenn .open gesetzt)
```

Das Menü öffnet und schließt sich per Click oder Tastatur (`Enter`/Leertaste) auf `#cyber-user-toggle`. Klicks außerhalb schließen es.

### Hintergrund-Effekte

```
.cyber-grid         Fixes Raster-Muster (60×60 px, orange-transparent)
.cyber-glow         Radialer Glow-Kreis oben, animiert (pulse 6s)
.cyber-corner       Eck-Dekorationen (tl/tr/bl/br)
body::before        Scanlines-Overlay (repeating-linear-gradient)
```

### Content-Bereich

```
.cyber-main          Zentrierender Wrapper (min-height 100vh)
.cyber-page-title    Seiten-Titel (fügt '// ' vor dem Titel ein)
.cyber-content-wrap  Panel mit Glasmorphism-Hintergrund, fadeUp-Animation
.cyber-prose         Typografie-Wrapper für CMS-Inhalte
```

### Prose-Stile (`cyber-prose`)

Formatiert CMS-Content automatisch:

- `h2` erhält ein vorangestelltes `// ` in Akzentfarbe
- `code` → orange, halbtransparenter Hintergrund
- `pre` → Surface-Hintergrund, linker Akzentrahmen
- `blockquote` → linker Akzentrahmen, gedämpfte Farbe
- `table` → Monospace-Header in Orange, Border-Kollaps

### Footer

```
.cyber-footer       Fixierter Footer unten
.cyber-clock        Live-Uhr (#cyber-clock, per JS aktualisiert), links
.cyber-copyright    Copyright-Hinweis, zentriert (© Jahr Site-Name)
.cyber-footer-menu  Rechts verankerte Footer-Menügruppen im HUD-Balken
.cyber-footer-link  Einzel-Link im Footer-Menü
```

### Buttons & Fehlerseite

```
.cyber-btn          Monospace-Button/Link mit Akzent-Rahmen
.cyber-error        Fehlerseiten-Wrapper (zentriert)
.cyber-error-code   Großer Fehlercode
.cyber-error-title  Titel-Zeile (// PREFIX)
.cyber-error-msg    Meldungstext
.cyber-error-links  Link-Container (.cyber-btn)
```

### Status-Anzeige

```
.cyber-status       "ONLINE"-Label mit blinkendem Dot
.cyber-status-dot   Grüner Dot (blink-Animation 2s)
```

## esse-grid Support

Das Theme unterstützt das ESSE-Grid-System für mehrspaltige Layouts in CMS-Inhalten:

```html
<div class="esse-grid-wrap">
    <div class="esse-grid" data-cols="3">
        <div class="esse-grid-item">Inhalt</div>
        <div class="esse-grid-item">Inhalt</div>
        <div class="esse-grid-item">Inhalt</div>
    </div>
</div>
```

| `data-cols` | Spalten Desktop | Tablet (≤768px) | Mobil (≤480px) ||-------------|-----------------|-----------------|-----------------|
| `2`         | 2               | 2               | 2               |
| `3`         | 3               | 2               | 2               |
| `4`         | 4               | 2               | 2               |
| `6`         | 6               | 3               | 2               |

## ESSE-UI-Integration

Das Theme lädt `/public/vendor/esse-ui/esse-ui.css` und überschreibt die `esse-*` Komponenten über `assets/css/esse-cyber.css`.

```css
.esse-panel,
.esse-btn,
.esse-alert,
.esse-table,
.esse-tabs-btn,
.esse-empty-state { ... }
```

Plugin-Ausgaben sollen die CMS-eigenen `esse-*` Klassen verwenden und werden dadurch im Cyber-Stil dargestellt.

## Open Graph

`layout.php` setzt automatisch im `<head>`:

| Tag | Quelle |
|---|---|
| `og:title` | `$page['title'] // $siteName` |
| `og:type` | `website` (fest) |
| `og:url` | `HTTP_HOST` + `REQUEST_URI` |
| `og:description` | `$page['description']` (nur wenn gesetzt) |
| `meta[name=description]` | `$page['description']` (nur wenn gesetzt) |

## Theme.php — Boot-Prozess

```php
public function boot(): void
```

1. Lädt alle CMS-Settings aus der Datenbank in `$this->settings`
2. Registriert `renderPage()` auf dem Hook `page.render`

```php
public function renderPage(array $page, string $content): void
```

Liest `site_name` und die Menü-Slugs aus Settings, lädt die Menü-Arrays per `Menu::get()` und includiert je nach `$page['error_code']` entweder `error.php` oder `layout.php`.
