# Changelog

Alle nennenswerten Änderungen an diesem Theme werden hier dokumentiert.  
Format nach [Keep a Changelog](https://keepachangelog.com/de/0.2.0/), Versionierung nach [Semantic Versioning](https://semver.org/lang/de/).

---

## [0.2.0] – 2026-06-03

### Hinzugefügt
- `README.md` mit vollständiger Theme-Dokumentation (Verzeichnisstruktur, Design-Tokens, CSS-Komponenten, Template-Variablen, esse-grid, Bootstrap-Integration)
- `a:focus-visible`, `button:focus-visible`, `input:focus-visible` u. a. — sichtbare Tastaturfokus-Styles mit `--accent2`-Outline
- `:focus-within`-Unterstützung für Dropdown-Menüs (bisher nur `:hover`)
- `@media (prefers-reduced-motion: reduce)` — deaktiviert Glow-Pulse, Status-Blink, Fade-in und Scanlines
- `@media (max-width: 600px)` — Footer nicht mehr `position: fixed`, Navigation ausgeblendet, reduziertes Padding

### Geändert
- `--muted` von `#6b6b78` auf `#9a9aa8` angehoben (Kontrastverhältnis auf `--bg` ca. 5,8:1 statt 3,9:1)
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
- Schriften: Rajdhani (300/500/700) und Share Tech Mono (400), lokal eingebunden
