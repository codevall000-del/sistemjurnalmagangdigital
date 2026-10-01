---
name: Serene Academic Desk
colors:
  surface: '#f8f9ff'
  surface-dim: '#ccdbf3'
  surface-bright: '#f8f9ff'
  surface-container-lowest: '#ffffff'
  surface-container-low: '#eff4ff'
  surface-container: '#e6eeff'
  surface-container-high: '#dce9ff'
  surface-container-highest: '#d5e3fc'
  on-surface: '#0d1c2e'
  on-surface-variant: '#43474e'
  inverse-surface: '#233144'
  inverse-on-surface: '#eaf1ff'
  outline: '#74777f'
  outline-variant: '#c4c6cf'
  surface-tint: '#455f87'
  primary: '#022448'
  on-primary: '#ffffff'
  primary-container: '#1e3a5f'
  on-primary-container: '#8aa4cf'
  inverse-primary: '#adc8f5'
  secondary: '#126588'
  on-secondary: '#ffffff'
  secondary-container: '#94d7ff'
  on-secondary-container: '#015f81'
  tertiary: '#122537'
  on-tertiary: '#ffffff'
  tertiary-container: '#283b4d'
  on-tertiary-container: '#92a5bb'
  error: '#ba1a1a'
  on-error: '#ffffff'
  error-container: '#ffdad6'
  on-error-container: '#93000a'
  primary-fixed: '#d5e3ff'
  primary-fixed-dim: '#adc8f5'
  on-primary-fixed: '#001c3b'
  on-primary-fixed-variant: '#2d486d'
  secondary-fixed: '#c4e7ff'
  secondary-fixed-dim: '#8ccff6'
  on-secondary-fixed: '#001e2c'
  on-secondary-fixed-variant: '#004c69'
  tertiary-fixed: '#d1e5fc'
  tertiary-fixed-dim: '#b5c9df'
  on-tertiary-fixed: '#081d2e'
  on-tertiary-fixed-variant: '#36495b'
  background: '#f8f9ff'
  on-background: '#0d1c2e'
  surface-variant: '#d5e3fc'
typography:
  headline-xl:
    fontFamily: Plus Jakarta Sans
    fontSize: 32px
    fontWeight: '700'
    lineHeight: 40px
    letterSpacing: -0.02em
  headline-lg:
    fontFamily: Plus Jakarta Sans
    fontSize: 24px
    fontWeight: '600'
    lineHeight: 32px
    letterSpacing: -0.015em
  headline-md:
    fontFamily: Plus Jakarta Sans
    fontSize: 20px
    fontWeight: '600'
    lineHeight: 28px
    letterSpacing: -0.01em
  headline-sm:
    fontFamily: Plus Jakarta Sans
    fontSize: 16px
    fontWeight: '600'
    lineHeight: 24px
    letterSpacing: -0.005em
  body-lg:
    fontFamily: Inter
    fontSize: 16px
    fontWeight: '400'
    lineHeight: 26px
    letterSpacing: 0em
  body-md:
    fontFamily: Inter
    fontSize: 14px
    fontWeight: '400'
    lineHeight: 22px
    letterSpacing: 0em
  body-sm:
    fontFamily: Inter
    fontSize: 13px
    fontWeight: '400'
    lineHeight: 18px
    letterSpacing: 0.005em
  label-md:
    fontFamily: Inter
    fontSize: 12px
    fontWeight: '600'
    lineHeight: 16px
    letterSpacing: 0.02em
  label-sm:
    fontFamily: Inter
    fontSize: 11px
    fontWeight: '500'
    lineHeight: 14px
    letterSpacing: 0.03em
rounded:
  sm: 0.25rem
  DEFAULT: 0.5rem
  md: 0.75rem
  lg: 1rem
  xl: 1.5rem
  full: 9999px
spacing:
  gutter: 1.5rem
  margin: 2rem
  space-xs: 0.25rem
  space-sm: 0.5rem
  space-md: 1rem
  space-lg: 1.5rem
  space-xl: 2rem
---

## Brand & Style

This design system establishes a focused, reassuring, and impeccably structured digital workroom for university students, mentors, and corporate supervisors. Balancing administrative rigor with approachable usability, the visual tone eliminates bureaucratic intimidation while cultivating accountability and professional maturity.

The design movement combines **Modern Corporate Minimalism** with intentional **Tonal Layering**. It avoids decorative distractions, loud gradients, and hyper-saturated interface accents. Instead, the interface relies on calibrated visual ergonomics: generous negative space, refined micro-borders, purposeful typographic hierarchy, and a quiet, academic coolness that reduces visual fatigue during extended daily journal writing and evaluation cycles.

## Colors

The palette is anchored by deep calm slate-navy and muted azure tones, balanced against an expansive, low-fatigue slate canvas.

- **Primary (`#1E3A5F`)**: A poised, deep academic navy. Used for main interactive triggers, navigation anchors, prominent headings, and active state indicators.
- **Secondary (`#3B82A6`)**: Soft, desaturated calm azure. Used for supportive actions, focus rings, progress fills, and active filter highlights without competing with content.
- **Tertiary (`#5B6E82`)**: Muted cool slate. Used for metadata, category labels, subtle iconography, and tab segment controls.
- **Neutral (`#475569`)**: Balanced body text slate. Rendered against light neutral backgrounds to ensure high legibility and softer optical contrast than harsh jet-black.

### Functional Status Tokens
- **Approved / Disetujui**: Background `#ECFDF5`, Border `#A7F3D0`, Text `#065F46` (Subtle Sage Green).
- **Pending Review / Menunggu Review**: Background `#FFFBEB`, Border `#FDE68A`, Text `#92400E` (Gentle Amber Ochre).
- **Draft / Draf**: Background `#F1F5F9`, Border `#CBD5E1`, Text `#475569` (Muted Slate).
- **Revision / Revisi**: Background `#FEF2F2`, Border `#FECACA`, Text `#991B1B` (Calm Crimson).

### Surface Layers
- **App Canvas**: `#F8FAFC` (Slate 50).
- **Surface Elevation 0 (Card / Table Surface)**: `#FFFFFF` (Pure White).
- **Surface Elevation 1 (Sidebar / Panels)**: `#F1F5F9` (Slate 100).
- **Structural Outlines & Dividers**: `#E2E8F0` (Slate 200).

## Typography

The typographic strategy pairs **Plus Jakarta Sans** for structural headlines with **Inter** for sustained reading comfort across dense tabular records and long reflection essays.

- **Headlines (Plus Jakarta Sans)**: Introduces structured, friendly authority with calibrated negative tracking to preserve clarity on desktop dashboards.
- **Body & Longform (Inter)**: Delivers unmatched neutral legibility with relaxed line-heights (`1.55`–`1.625`) to prevent eye fatigue when reading lengthy daily journal entries and mentor feedback.
- **Labels & Numbers**: Monospaced tabular figures (`tnum`) must be enforced on data grids, submission timestamps, and duration counters.

## Layout & Spacing

The desktop layout follows a disciplined **8pt baseline rhythm** organized around a responsive fixed-max desktop container (`max-width: 1440px`) with a persistent left navigation column.

### Shell Architecture
- **Persistent Left Navigation**: Fixed `260px` sidebar containing portal navigation, profile overview, and university affiliation badges.
- **Main Canvas**: Fluid with minimum `margin` of `2rem` (32px) and standard horizontal `gutter` of `1.5rem` (24px).
- **Split Workspace**: When authoring or inspecting logs, use a split-pane layout (60% active entry form / 40% contextual reference panel, mentor annotations, and historical activity timeline).

### Content Breakpoints
- **Desktop Standard (`1280px`–`1440px`)**: Full 12-column content grid, persistent navigation, multi-column analytics summary.
- **Compact Desktop / Tablet Landscape (`1024px`–`1279px`)**: Sidebar condenses to `72px` icon rail, right inspection pane converts into a dismissible drawer sheet.

## Elevation & Depth

Visual separation relies primarily on **subtle planar contrast** and **crisp 1px hairline dividers**, rather than heavy drop shadows.

- **Flat/Ground Tier**: Canvas base `#F8FAFC` provides the stage for all floating elements.
- **Card Tier (Level 0)**: Pure `#FFFFFF` fill bounded by a crisp `1px solid #E2E8F0` border. No drop shadow in default state; hovers introduce `box-shadow: 0 2px 8px -2px rgba(30, 58, 95, 0.06), 0 1px 4px -1px rgba(30, 58, 95, 0.04)`.
- **Overlay & Dropdown Tier (Level 1)**: Pure `#FFFFFF` surface with `1px solid #E2E8F0` and `box-shadow: 0 10px 24px -4px rgba(30, 58, 95, 0.08), 0 4px 8px -2px rgba(30, 58, 95, 0.04)`.
- **Modal Tier (Level 2)**: Backed by a serene slate veil (`rgba(15, 23, 42, 0.35)` with `backdrop-filter: blur(4px)`).

## Shapes

The design uses a clean, architectural curvature (Level 2: `0.5rem` / `8px` default radius). This provides a modern, soft feel while maintaining the orderly posture required for administrative forms and documents.

- **Cards, Modals, Panels**: `rounded-lg` (`1rem` / `16px`) for primary organizational surfaces.
- **Inputs, Buttons, Dropdowns**: `rounded` (`0.5rem` / `8px`) for immediate affordance.
- **Badges, Tags, User Avatars**: `rounded-full` (`9999px`) to distinguish categorical metadata from interactive structural tiles.

## Components

### Buttons
- **Primary**: Background `#1E3A5F`, text `#FFFFFF`, radius `8px`, height `40px`, padding `0 16px`. Hover state shifts to `#162C46` with smooth `150ms ease` transition.
- **Secondary / Ghost**: Background transparent, border `1px solid #E2E8F0`, text `#1E3A5F`. Hover fills with `#F8FAFC` and border `#CBD5E1`.
- **Tertiary Link**: Clean text button with `#3B82A6` styling, no border, underline on hover.

### Status Badges
- Compact indicators rendered with `rounded-full`, height `24px`, padding `0 10px`, font size `11px`, font weight `600`.
- **Disetujui**: Green badge (`#ECFDF5`, border `#A7F3D0`, text `#065F46`) preceded by an optional 6px solid dot.
- **Menunggu Review**: Warm amber badge (`#FFFBEB`, border `#FDE68A`, text `#92400E`).
- **Draf**: Neutral slate badge (`#F1F5F9`, border `#CBD5E1`, text `#475569`).

### Form Inputs & Textareas
- Border `1px solid #CBD5E1`, background `#FFFFFF`, text `#1E293B`, placeholder `#94A3B8`.
- Focus state: Border color `#3B82A6` with an outer ring of `0 0 0 3px rgba(59, 130, 166, 0.15)`. No default browser outlines.
- Longform journal textareas must support expandable vertical heights with contextual word/character count metrics placed below the bottom-right boundary.

### Cards & Data Lists
- **Log Entry Card**: Divided into header (Date, Log Status, Category Pill), body (Brief excerpt, tagged competencies), and footer (Mentor signature indicator or comment count).
- Separators use hairline `#E2E8F0`. Hovering an entry reveals a subtle `#F8FAFC` tint and subtle border illumination `#CBD5E1`.

### Verification & Signature Block
- Dedicated component for supervisor sign-offs featuring a clean dual-column layout: timestamped student declaration on the left, supervisor validation status and digital stamp/pin confirmation on the right.