# Changelog

Alle nennenswerten Änderungen an diesem Theme werden hier dokumentiert.  
Format nach [Keep a Changelog](https://keepachangelog.com/de/0.2.0/), Versionierung nach [Semantic Versioning](https://semver.org/lang/de/).

---

## [0.3.0] - 2026-06-04

### Hinzugefügt
- Login-Dropdown bleibt nach fehlgeschlagenem Navbar-Login sichtbar und fokussiert das Passwortfeld.
- User-Menü lässt sich per Tastatur mit `Enter` und Leertaste öffnen.
- Links im Content sind zusätzlich zur Akzentfarbe unterstrichen.
- Lokaler Rajdhani-400-Webfont ersetzt die bisherigen Rajdhani-Schnitte, um Firefox-Font-Warnungen durch Glyph-Bounding-Boxes zu vermeiden.
- Bootstrap-Content-Komponenten wie Cards, List-Groups, Alerts, Buttons und Formfelder erhalten Cyber-Styles innerhalb des Theme-Content-Bereichs.

### Geändert
- Scanlines abgeschwächt, kleinere UI-Texte ruhiger gesetzt und Letter-Spacing weiter reduziert.
- Footer-Texte und Fehlermeldungen besser lesbar gemacht.
- Footer als HUD-Balken mit linker Uhr und rechts verankerten Menügruppen ausgerichtet.
- Untere Corner-Brackets behalten Abstand zur Browserkante.
- Untere HUD-Trennlinie zwischen den Footer-Brackets analog zur Topbar dezent gesetzt.
- Schwarzer Balken bleibt unterhalb der Brackets sichtbar.
- README an aktuelle Fonts, Farben und Interaktionszustände angepasst.

---

## [0.2.0] – 2026-06-03

### Hinzugefügt
- `README.md` mit vollständiger Theme-Dokumentation (Verzeichnisstruktur, Design-Tokens, CSS-Komponenten, Template-Variablen, esse-grid, Bootstrap-Integration)
- `a:focus-visible`, `button:focus-visible`, `input:focus-visible` u. a. — sichtbare Tastaturfokus-Styles mit `--accent2`-Outline
- `:focus-within`-Unterstützung für Dropdown-Menüs (bisher nur `:hover`)
- `@media (prefers-reduced-motion: reduce)` — deaktiviert Glow-Pulse, Status-Blink, Fade-in und Scanlines
- `@media (max-width: 600px)` — Footer nicht mehr `position: fixed`, Navigation ausgeblendet, reduziertes Padding

### Geändert
- `--muted` von `#6b6b78` auf `#9a9aa8` angehoben (Kontrastverhältnis auf `--bg` ca. 7,3:1 statt 3,9:1)
- Mindesttextgröße für interaktive Kleinst-Texte auf `0.8 rem` angehoben (bisher `0.6–0.65 rem`)
- Login-Formfelder auf `0.85 rem` angehoben (bisher `0.65 rem`)
- `letter-spacing` bei kleinen Texten von `0.08–0.1 em` auf `0.05 em` reduziert

---

## [0.1.0] – 2026-06-03

Erste Veröffentlichung des esse-cyber Themes.

### Enthalten
- Cyberpunk-Terminal-Layout mit Scanlines, Grid-Hintergrund und orangem Akzent
- Topbar mit Haupt-Navigation, Dropdown (ein Level), User-/Login-Menü und Status-Dot
- Fixierter Footer mit Live-Uhr und gruppierbarer Footer-Navigation
- Fehlerseiten-Template (`error.php`)
- esse-grid Standard-Klassen (2 – 6 Spalten, responsive)
- Bootstrap 5 Integration mit Container-Reset innerhalb von `.cyber-content-wrap`
- Schriften: Rajdhani und Share Tech Mono, lokal eingebunden
