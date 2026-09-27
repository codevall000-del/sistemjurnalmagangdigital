---
name: Field Verified Enterprise PKL
colors:
  surface: '#f8f9ff'
  surface-dim: '#cbdbf5'
  surface-bright: '#f8f9ff'
  surface-container-lowest: '#ffffff'
  surface-container-low: '#eff4ff'
  surface-container: '#e5eeff'
  surface-container-high: '#dce9ff'
  surface-container-highest: '#d3e4fe'
  on-surface: '#0b1c30'
  on-surface-variant: '#434655'
  inverse-surface: '#213145'
  inverse-on-surface: '#eaf1ff'
  outline: '#747686'
  outline-variant: '#c4c5d7'
  surface-tint: '#2151da'
  primary: '#0037b0'
  on-primary: '#ffffff'
  primary-container: '#1d4ed8'
  on-primary-container: '#cad3ff'
  inverse-primary: '#b7c4ff'
  secondary: '#565e74'
  on-secondary: '#ffffff'
  secondary-container: '#dae2fd'
  on-secondary-container: '#5c647a'
  tertiary: '#004f35'
  on-tertiary: '#ffffff'
  tertiary-container: '#006948'
  on-tertiary-container: '#76eab6'
  error: '#ba1a1a'
  on-error: '#ffffff'
  error-container: '#ffdad6'
  on-error-container: '#93000a'
  primary-fixed: '#dce1ff'
  primary-fixed-dim: '#b7c4ff'
  on-primary-fixed: '#001551'
  on-primary-fixed-variant: '#0039b5'
  secondary-fixed: '#dae2fd'
  secondary-fixed-dim: '#bec6e0'
  on-secondary-fixed: '#131b2e'
  on-secondary-fixed-variant: '#3f465c'
  tertiary-fixed: '#85f8c4'
  tertiary-fixed-dim: '#68dba9'
  on-tertiary-fixed: '#002114'
  on-tertiary-fixed-variant: '#005137'
  background: '#f8f9ff'
  on-background: '#0b1c30'
  surface-variant: '#d3e4fe'
typography:
  headline-xl:
    fontFamily: Space Grotesk
    fontSize: 36px
    fontWeight: '700'
    lineHeight: 44px
    letterSpacing: -0.02em
  headline-xl-mobile:
    fontFamily: Space Grotesk
    fontSize: 28px
    fontWeight: '700'
    lineHeight: 36px
    letterSpacing: -0.01em
  headline-lg:
    fontFamily: Space Grotesk
    fontSize: 30px
    fontWeight: '600'
    lineHeight: 38px
    letterSpacing: -0.015em
  headline-lg-mobile:
    fontFamily: Space Grotesk
    fontSize: 24px
    fontWeight: '600'
    lineHeight: 32px
    letterSpacing: -0.01em
  headline-md:
    fontFamily: Space Grotesk
    fontSize: 22px
    fontWeight: '600'
    lineHeight: 28px
    letterSpacing: -0.01em
  headline-sm:
    fontFamily: Space Grotesk
    fontSize: 18px
    fontWeight: '600'
    lineHeight: 24px
    letterSpacing: 0em
  body-lg:
    fontFamily: Geist
    fontSize: 16px
    fontWeight: '400'
    lineHeight: 24px
    letterSpacing: 0em
  body-md:
    fontFamily: Geist
    fontSize: 14px
    fontWeight: '400'
    lineHeight: 20px
    letterSpacing: 0em
  body-sm:
    fontFamily: Geist
    fontSize: 12px
    fontWeight: '400'
    lineHeight: 16px
    letterSpacing: 0.01em
  label-md:
    fontFamily: Geist
    fontSize: 13px
    fontWeight: '500'
    lineHeight: 18px
    letterSpacing: 0.01em
  label-sm:
    fontFamily: Geist
    fontSize: 11px
    fontWeight: '600'
    lineHeight: 14px
    letterSpacing: 0.04em
  code-sm:
    fontFamily: Geist
    fontSize: 12px
    fontWeight: '500'
    lineHeight: 16px
    letterSpacing: 0.02em
rounded:
  sm: 0.25rem
  DEFAULT: 0.5rem
  md: 0.75rem
  lg: 1rem
  xl: 1.5rem
  full: 9999px
spacing:
  gutter: 1.5rem
  gutter-mobile: 1rem
  margin: 2rem
  margin-mobile: 1rem
  space-xs: 0.25rem
  space-sm: 0.5rem
  space-md: 1rem
  space-lg: 1.5rem
  space-xl: 2rem
---

## Brand & Style

This design system delivers an operational, high-integrity digital journal and verification environment tailored for vocational internship tracking (PKL), industrial apprenticeships, and enterprise academic oversight. The visual identity operates at the intersection of a structured field notebook and an institutional audit ledger: rigorous, authentic, and unambiguous.

### Emotional Demeanor & Personality
- **Institutional Rigor:** The system conveys procedural legitimacy, accountability, and real-time verifiable logging.
- **Engineered Utilitarianism:** Information density is prioritized over decorative filler. Work units, verification signatures, attendance states, and log evaluations are rendered with zero optical distortion.
- **Academic & Corporate Synergy:** The aesthetic balances the compliance requirements of university faculties with the productivity standards of enterprise host companies.

### Design Movements
- **Technical Ledger Minimalism:** Strictly flat, solid-state architecture devoid of gradients, skeuomorphic noise, or synthetic glass blurs.
- **Monospace-Leaning Geometric Hierarchy:** High-legibility technical titling using Space Grotesk contrasted against the neutral, systematic precision of Geist for long-form journal entries, supervisor feedback, and metric readouts.
- **Deterministic State Modeling:** Surfaces rely on explicit 1px slate boundaries (`#E2E8F0`), flat semantic status blocks, and discreet mechanical transitions.

## Colors

The color palette is engineered strictly for light-mode operational visibility, adhering to a zero-gradient, flat solid-color paradigm. All chromatic assignments signify status, hierarchy, or interactive affordance.

### Primary & Core Tonal Structure
- **Primary Sapphire (`#1D4ED8`):** Authoritative operational primary used for active tabs, primary action triggers, validated timestamps, and focal indicators.
- **Secondary Slate/Navy (`#0F172A`):** The terminal anchor color, applied to primary typography, master table headings, shell headers, and high-emphasis data points.
- **Supporting Neutral Sub-base (`#334155`):** Secondary typography, metadata descriptors, and structural icon elements.
- **Muted Neutral (`#64748B`):** Tertiary captions, audit table helper copy, inactive column dividers, and placeholder boundaries.

### Background & Border Layers
- **Canvas Base (`#F8FAFC`):** The clean slate ground plane representing all backdrop areas outside bounded containers.
- **Card & Surface (`#FFFFFF`):** High-clarity white surface containers hosting log lists, timesheets, and metric widgets.
- **Border Structural Rule (`#E2E8F0`):** Single-pixel, unblurred architectural partitions separating interactive panels and audit grids.

### Semantic Status Colors
- **Verified / Present (`#059669`):** Pure emerald tone representing verified workplace attendance, mentor sign-offs, and completed learning outcomes.
- **Pending Review (`#D97706`):** Pure amber tone designating unread daily activities, queue states, or student drafts pending industrial mentor approval.
- **Absent / Flagged (`#E11D48`):** Pure rose red identifying missing records, attendance deficits, rejected milestones, or overdue weekly submissions.

## Typography

The typographic hierarchy implements Space Grotesk for major technical landmarks, verification stamps, and section headers. Body layers, tables, and interaction points utilize Geist to maintain readability across dense tabular views and multi-paragraph daily reports.

### Typographic Principles
- **Data Densities:** Journal metrics, time records, and institutional codes (`PKL-ID`, timestamps, GPS lat/long tags) utilize `code-sm` or `label-sm` with upper-case tracking for immediate scanability.
- **Editorial Legibility:** Multi-line log reflections are constrained to a line-height multiplier between 1.45 and 1.5 in Geist to preserve rhythm during review workflows.
- **Display Restraint:** Space Grotesk is strictly confined to system headers, card titles, key metric numbers, and modal dialog caps.

## Layout & Spacing

The layout model enforces a controlled 12-column desktop grid tailored for enterprise dashboards, transitioning to a flexible 4-column framework on mobile devices.

### Breakpoints & Layout Engine
- **Desktop (1280px and above):** 12-column layout. Global canvas margin is fixed at `2rem` (`margin`), with column gutters locked at `1.5rem` (`gutter`). Navigation persists as a fixed 260px vertical utility sidebar.
- **Tablet (768px - 1279px):** 8-column layout. Margins collapse to `1.5rem`, gutters remain `1.5rem`. Secondary panels (mentor commentary, activity preview) fold into expandable bottom sheets or secondary tabs.
- **Mobile (below 768px):** 4-column fluid layout with `1rem` (`margin-mobile`) exterior padding and `1rem` (`gutter-mobile`) column spacing. All cards and data rows collapse to full-width stacked configurations.

### Spatial Rhythm
Padding inside operational cards, verification tables, and modal headers is strictly governed by the 4px baseline rhythm (`space-xs: 4px`, `space-sm: 8px`, `space-md: 16px`, `space-lg: 24px`, `space-xl: 32px`). Density in table cells stays anchored at `space-sm` vertically and `space-md` horizontally to preserve maximal vertical viewport area for entries.

## Elevation & Depth

Visual hierarchy rejects exaggerated drop shadows and multi-stop lighting effects in favor of clean structural containment, crisp division lines, and shallow architectural elevation.

### Structural Stratification
- **Ground Floor (Base Canvas):** Set to `#F8FAFC`. Houses the application layout and non-actionable surface backplanes.
- **Level 1 (Card & Module Surfaces):** Set to `#FFFFFF` bounded by a mandatory 1px solid border (`#E2E8F0`). Elevation is amplified only through a subtle micro-shadow (`box-shadow: 0 1px 2px 0 rgba(15, 23, 42, 0.05)`).
- **Level 2 (Hover States & Inline Triggers):** Subtle elevation increase (`box-shadow: 0 1px 3px 0 rgba(15, 23, 42, 0.10)`) paired with a border shift from `#E2E8F0` to `#64748B`.
- **Level 3 (Modals, Slide-over Menus, and Drawers):** Bounded by 1px solid `#E2E8F0` with a sharp overlay shadow (`box-shadow: 0 10px 15px -3px rgba(15, 23, 42, 0.08), 0 4px 6px -4px rgba(15, 23, 42, 0.04)`). The backdrop uses a pure, unblurred neutral shield: `rgba(15, 23, 42, 0.40)`.

## Shapes

The geometric framework applies a consistent `roundedness: 2` (rounded) across all UI elements, balancing technical discipline with modern interface norms.

### Corner Radius Mapping
- **Standard Structural Elements (`0.5rem` / `8px`):** Used on all standard buttons, text inputs, dropdowns, table row selection highlights, and status tags.
- **Card Containers & Modules (`rounded-lg` / `1rem` / `16px`):** All journal log wrappers, attendance overview blocks, analytics charts, and dialogue frames utilize standard `1rem` radii.
- **Top-Level Modals & Slide-outs (`rounded-xl` / `1.5rem` / `24px`):** Large-scale interactive overlays, certificate previews, and floating approval hubs.
- **Pill Exceptions:** Avatar badges, state indicator dots, and micro numeric notifications may use full circular geometry (`rounded-full`), while all functional action items strictly conform to the 0.5rem or 1rem tokens.

## Components

### Buttons
- **Primary Operational Button:** Solid `#1D4ED8` background, `#FFFFFF` text, `0.5rem` corner radius, `space-sm` (8px) vertical by `space-md` (16px) horizontal padding. Focus ring: 2px solid `#1D4ED8` offset by 2px white. Active state darkens to `#1E40AF`. Zero gradient.
- **Secondary Action Button:** Solid `#FFFFFF` background, 1px solid border `#E2E8F0`, `#0F172A` text. Hover changes border to `#CBD5E1` and surface to `#F8FAFC`.
- **Destructive/Flagging Button:** Solid `#FFFFFF` surface, 1px solid `#E11D48`, text `#E11D48`. Hover shifts background to `#FFF1F2`.

### Status Badges & Chips
- **Verified / Present:** Solid `#ECFDF5` background, `#059669` text, 1px solid `#A7F3D0` border. Radius: `0.5rem`. Preceded by a 6px solid `#059669` circle indicator.
- **Pending Industrial Review:** Solid `#FFFBEB` background, `#D97706` text, 1px solid `#FDE68A` border.
- **Absent / Action Required:** Solid `#FFF1F2` background, `#E11D48` text, 1px solid `#FECDD3` border.

### Input Fields & Controls
- **Text Inputs & Textareas:** Solid `#FFFFFF` fill, 1px solid border `#E2E8F0`, `0.5rem` border radius. Typography: Geist 14px (`#0F172A`). Placeholder: `#64748B`. Focus state transitions border to `#1D4ED8` without soft outer glows.
- **Checkboxes & Radios:** 18px square/circle with 1px border `#CBD5E1`. Checked state: solid `#1D4ED8` fill with crisp `#FFFFFF` checkmark/indicator.

### Cards & Activity Log Items
- **Journal Entry Card:** `#FFFFFF` background, 1px solid `#E2E8F0` border, `rounded-lg` (16px) radius, `space-lg` (24px) internal padding, subtle `shadow-sm`. Header features student ID and timestamp in Geist Mono style (`label-sm`), Space Grotesk headline, and inline verification chip.
- **Mentor Sign-off Module:** Dedicated sub-surface tinted `#F8FAFC`, delimited by a 1px dashed `#CBD5E1` boundary, featuring supervisor signature field, rating scale, and verification timestamp.

### Data Tables
- **Audit Grid Table:** Clean edge-to-edge `#FFFFFF` surface. Header cells use `#F8FAFC` background, 11px uppercase Geist bold (`label-sm`), `#64748B` text, and a continuous bottom border of 1px solid `#E2E8F0`. Row heights are fixed at 48px with zebra striping avoided in favor of 1px horizontal dividers. Hover row color shifts to `#F8FAFC`.