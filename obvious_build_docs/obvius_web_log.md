# Obvius Digital — Website Project Log
**Author: Toluwalase Mebaanne**
**Version: Running (append-only)**
**Started: March 2026**

---

> This log is append-only. Nothing gets deleted. Items get marked resolved, not removed.
> Format: `[DATE] [TYPE] Entry`
> Types: DECISION | OBSERVATION | ISSUE | DEFERRED | RESOLVED

---

## Log

---

**[2026-03-04] DECISION** — Stack confirmed: Astro + GitHub + Hostinger. Rationale: component reuse for repeated elements (header, footer, forms, reviews), blog-as-markdown-folder, 100% static output, existing Hostinger Git deployment already configured.

**[2026-03-04] DECISION** — Form handling: PHP script on Hostinger. No third-party service (Formspree and Web3Forms evaluated and rejected — goal was to avoid stacking services). Hostinger plan confirmed to include PHP. Form POSTs to `contact.php` in `/public`, which uses PHP `mail()` to deliver to Hostinger business email. Zero additional services required.

**[2026-03-04] DECISION** — Business email: Hostinger Free Email included in plan. Address will be `@obviusdigital.ca`. Currently showing "Pending setup" in Hostinger dashboard — must be set up before form testing.

**[2026-03-04] DECISION** — Rowdies font served locally from `public/fonts/` via `@font-face`. Not available on Google Fonts. Local serving avoids external request and guarantees availability.

**[2026-03-04] DECISION** — Blog built and deployed but hidden from navigation. Not a 404 — accessible at `/blog` for preview purposes. Will be linked in nav when first post is published.

**[2026-03-04] DECISION** — Google Reviews section built as a placeholder `div` in `Reviews.astro`. Text reviews displayed now. Widget drop-in requires zero structural change when ready.

**[2026-03-04] DECISION** — Services confirmed for V1: 360 Media Production, Digital Marketing, Consulting, Training, Website Development. Deferred: Digital Content Audits & Management, Digital Presence Strategy, Branding Package.

**[2026-03-04] DECISION** — Domain confirmed: `obviusdigital.ca`. Active in Hostinger dashboard.

**[2026-03-04] DECISION** — Existing WordPress install on `obviusdigital.ca` to be replaced entirely by Astro build on deploy. Confirmed unused — nothing to preserve.

**[2026-03-04] DECISION** — Social media handle confirmed as `@obviusdigital` across platforms. Instagram confirmed. Facebook, LinkedIn, YouTube assumed same handle — to be verified before launch.

**[2026-03-04] DECISION** — Phone number placeholder: +1 416 884 4080. To be swapped for permanent business number when available.

**[2026-03-04] DEFERRED** — All content items listed in Content Inventory "What Is Still Needed Before Launch" section. Not blocking build — blocking launch.

**[2026-03-04] DEFERRED** — Google Analytics measurement ID not yet provided. Placeholder in `BaseLayout.astro` — drop in the ID when available.

**[2026-03-04] DEFERRED** — Brand colour hex values not formally confirmed. Red and black visible from logo assets — exact values to be confirmed before CSS variables are finalised.

---

*New entries go below this line.*

---
