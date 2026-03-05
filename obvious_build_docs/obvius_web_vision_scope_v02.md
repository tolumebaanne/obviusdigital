# Obvius Digital — Website Project Vision & Scope
**Author: Toluwalase Mebaanne**
**Version: 02**
**Status: Active**

---

## What This Is

A marketing website for Obvius Digital — a creative digital agency offering 360 media production, digital marketing, consulting, training, and website development services. The site's primary purpose is to convert visitors into clients. The homepage carries most of the information load. The contact page is the conversion endpoint.

## Who It Is For

Small and medium-sized businesses — start-ups in particular — who need a trusted digital marketing partner. Clients who have found Obvius through referral, social media, or organic search.

## What Problem It Solves

Gives potential clients a professional, credible place to understand what Obvius does, see proof of past work, and initiate a project — without needing to reach out first just to understand the offering.

---

## First Version — What Is In

- **Homepage** — Full page as specified: hero, past clients, brand promise, services overview, why us grid, past work (3 examples), FAQ accordion, text-based client reviews, contact form, footer
- **About Us** — Hero, origin story, how we are different grid, founders message, reviews, contact form, footer
- **Services** — Overview page with service tiles linking to individual service pages
- **Our Work** — Past work showcase, CTA, reviews, contact form, footer
- **Contact Us** — Hero, social links, 3 big contact buttons (phone, email, IG DM), contact form, footer
- **Individual Service Pages** — 360 Media Production, Digital Marketing, Consulting, Training, Website Development (content TBD — placeholder structure built, ready for copy)
- **Blog** — Built but hidden. Not linked in navigation. Accessible via direct URL only until content is ready.
- **Shared components** — Header (logo + nav), Footer (4-column), Contact Form, Reviews Section

## What Is Explicitly NOT in Version 1

| Item | Reason | When |
|---|---|---|
| Blog content | No time to write articles yet | When ready — just add markdown files |
| Blog in navigation | Hidden until populated | When first post is published |
| Google Reviews widget | Not ready yet | Drop-in replacement for text reviews when ready |
| Individual service page copy | Content not provided yet | Before launch |
| Digital Content Audits & Management | Deferred service | V2 or when ready to offer |
| Digital Presence Strategy | Deferred service | V2 or when ready to offer |
| Branding Package | Deferred service | V2 or when ready to offer |
| CMS / admin panel | Static site — no CMS needed | Only if content updates become painful |
| E-commerce / payment | Not in scope | Never, unless business pivots |
| User accounts / login | Not in scope | Never, unless business pivots |

---

## Key Decisions

| Decision | Choice | Reasoning |
|---|---|---|
| Framework | Astro | Component reuse (shared header, footer, forms), blog-ready via content collections, outputs 100% static HTML |
| Hosting | Hostinger | Already set up, Git deployment configured, domain active |
| Domain | obviusdigital.ca | Confirmed in Hostinger dashboard |
| Version control | GitHub | Triggers Hostinger auto-deploy on push |
| CSS approach | Custom CSS per m0t.WEB.1 standard | Full control, no framework bloat, consistent with bible |
| Font | Rowdies (provided) | Brand font — Bold, Light, Regular weights available |
| Forms | PHP script on Hostinger | No third-party service — Hostinger plan includes PHP, form posts to PHP script which emails to Hostinger business email. Zero extra services. |
| Business email | Hostinger Free Email | `@obviusdigital.ca` — pending setup in Hostinger dashboard |
| Analytics | Google Analytics (GA4) | Script tag in shared layout component — ID to be provided |
| Blog | Astro Content Collections | Markdown files in `src/content/blog/` — hidden until populated |
| Google Reviews | Placeholder section | Text reviews now, widget swap-in later without structural change |
| Existing WordPress site | Replace entirely | Current WordPress install on obviusdigital.ca is unused — Astro build replaces it on deploy |

---

## Brand Assets Confirmed

- Logo (red + black, horizontal): `obvius_digital_logo_Croppedred.PNG`
- Logo (red + white on black): `obvius_digital_logored_white.png`
- Eye icon (standalone mark): `obvius_eyered.png`
- Font family: Rowdies — Bold, Light, Regular (`.ttf` files in Google Drive)
- Brand voice: Mature but agile, partner-focused, direct, intentional

---

## Open Items Before Launch

These must be resolved before the site goes live. They are content gaps, not build gaps.

- [ ] Founder profile photos
- [ ] Founder social links (Instagram, LinkedIn)
- [ ] FAQ questions and answers (minimum 4-6)
- [ ] 3 past work entries — real client logos, brand names, category tags, visuals
- [ ] Client reviews — minimum 3 (name + text)
- [ ] Past client logos (for logo strip on homepage)
- [ ] Hero graphics for inner pages
- [ ] Service page copy for all 5 services
- [ ] Business email set up in Hostinger (`@obviusdigital.ca`)
- [ ] Google Analytics measurement ID (GA4 — format: G-XXXXXXXXXX)
- [ ] Formspree replaced by PHP script — PHP mail script configured and tested

---

## What "Done" Means for Version 1

- All pages render correctly across desktop, tablet, and mobile
- Contact forms submit successfully and deliver to Obvius business email via PHP
- Google Analytics tracking confirmed active
- Blog is built but hidden from navigation
- All placeholder content is replaced with real content
- Site is deployed to Hostinger at obviusdigital.ca
- WordPress is fully replaced by the Astro build
- Google Reviews section is structured to accept the widget when ready

---

## Version History

| Version | Date | Change |
|---|---|---|
| 01 | March 2026 | Initial creation |
| 02 | March 2026 | Services corrected to 5 confirmed (3 deferred), domain confirmed as obviusdigital.ca, form handling changed from Formspree to PHP on Hostinger, WordPress replacement noted, business email noted, brand voice added |
