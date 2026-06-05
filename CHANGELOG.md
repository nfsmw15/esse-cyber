# Changelog

Alle nennenswerten Änderungen an diesem Theme werden hier dokumentiert.  
Format nach [Keep a Changelog](https://keepachangelog.com/de/0.2.0/), Versionierung nach [Semantic Versioning](https://semver.org/lang/de/).

---

## [0.5.2] – 2026-06-05

### Geändert
- Mobile Breakpoint von 600 px auf 768 px erhöht — Hamburger-Button und ONLINE-Ausblendung greifen jetzt zuverlässig auf allen Smartphones (Samsung-Browser, höhere DPI-Dichte)
- `min-height: 100vh` auf `.cyber-main` wird auf mobilen Viewports aufgehoben — kein großer Leerraum mehr zwischen Inhalt und statischem Footer

---

## [0.5.1] – 2026-06-04

### Geändert
- Copyright-Position: sitzt jetzt unterhalb der Bracket-Linie im Footer-HUD
- Topbar mobil: Logo übernimmt verfügbaren Platz, User-Button auf max. 8 rem begrenzt (Ellipsis bei langen Namen), ONLINE-Status ausgeblendet
- Bootstrap-Badge-Klassen (`bg-warning/info/success/danger/primary/secondary`) auf Cyber-Stil überschrieben
- Gallery-Plugin-Badges (`gal-badge-private/public/intern/extern/count`) auf Cyber-Stil überschrieben

---

## [0.5.0] – 2026-06-04

### Hinzugefügt
- Copyright-Hinweis im Footer-HUD-Balken, zentriert zwischen Uhr und Navigation
- Mobile Navigation: Hamburger-Button öffnet fullscreen-Overlay mit allen Menüpunkten; Dropdowns expandieren inline; schließt per ✕-Button oder `Escape`; fokus-sicher
- Globale Formular-Styles: `input`, `select`, `textarea`, `label` im Cyber-Stil (Surface-Hintergrund, Mono-Font, Akzent-Border bei Fokus, eigener `select`-Pfeil, `accent-color` für Checkboxen)
- Skip-to-content Link: bei Tab-Navigation sichtbar, springt zu `#cyber-main`
- Open Graph Meta Tags: `og:title`, `og:type`, `og:url`, `og:description` im `<head>`
- Print-Styles: Topbar, Footer, Hintergrund-Effekte und Scanlines beim Drucken deaktiviert, lesbarer Schwarz-Weiß-Druck

### Geändert
- Login-Formular-Inline-Styles entfernt, werden von den globalen Formular-Styles gedeckt

---

## [0.4.2] – 2026-06-04

### Geändert
- `esse-badge--warning/info/success/danger`: semantische Badges auf Cyber-Stil umgestellt — transparenter Hintergrund, farbiger Border und Text statt Bootstrap-Solid-Blöcke; greift global (auch außerhalb von `.cyber-content-wrap`)

---

## [0.4.1] – 2026-06-04

### Geändert
- `esse-btn--primary`: globaler Fallback ergänzt — Button ist auf Plugin-Seiten ohne `.cyber-content-wrap` jetzt mit klarer Kontur und Farbsättigung sichtbar
- `esse-table`: globaler `tbody tr:hover`-Fallback verhindert weißen Hintergrund auf Plugin-Seiten außerhalb des Content-Wrappers

---

## [0.4.0] - 2026-06-05

### Hinzugefügt
- ESSE-UI-Komponenten wie Panels, Buttons, Alerts, Badges, Tabellen, Tabs und Empty-States erhalten Cyber-Styles innerhalb des Theme-Content-Bereichs.

### Geändert
- Externe UI-Framework-Assets werden nicht mehr geladen; Plugin-Ausgaben werden über `esse-ui.css` und `esse-*` Klassen gestylt.
- Hintergrund-Grid minimal sichtbarer gemacht und den orangenen Glow vergrößert.
- README auf ESSE-UI-Integration aktualisiert.

---

## [0.3.0] - 2026-06-04

### Hinzugefügt
- Login-Dropdown bleibt nach fehlgeschlagenem Navbar-Login sichtbar und fokussiert das Passwortfeld.
- User-Menü lässt sich per Tastatur mit `Enter` und Leertaste öffnen.
- Links im Content sind zusätzlich zur Akzentfarbe unterstrichen.
- Lokaler Rajdhani-400-Webfont ersetzt die bisherigen Rajdhani-Schnitte, um Firefox-Font-Warnungen durch Glyph-Bounding-Boxes zu vermeiden.

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
- `README.md` mit vollständiger Theme-Dokumentation (Verzeichnisstruktur, Design-Tokens, CSS-Komponenten, Template-Variablen, esse-grid)
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
- Schriften: Rajdhani und Share Tech Mono, lokal eingebunden
