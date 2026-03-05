# Obvius Digital — Site Architecture
**Author: Toluwalase Mebaanne**
**Version: 02**
**Status: Active**

---

## Site Map

```
                        ┌─────────────────────────────────────────┐
                        │           OBVIUS DIGITAL WEBSITE         │
                        │      obviusdigital.ca (Astro + Hostinger)│
                        └──────────────────┬──────────────────────┘
                                           │
                    ┌──────────────────────▼──────────────────────┐
                    │               SHARED LAYOUT                  │
                    │   Header (Logo + Nav) | Footer (4-col)       │
                    │   Google Analytics Script | Rowdies Font     │
                    └──┬───────┬──────┬───────┬──────┬────────────┘
                       │       │      │       │      │
             ┌─────────▼─┐ ┌───▼──┐ ┌─▼────┐ ┌▼───────┐ ┌▼──────────┐
             │  HOME      │ │ABOUT │ │SERV- │ │OUR     │ │CONTACT    │
             │  /         │ │/about│ │ICES  │ │WORK    │ │/contact   │
             │            │ │      │ │/serv-│ │/work   │ │           │
             └────────────┘ └──────┘ │ices  │ └────────┘ └───────────┘
                                     └──┬───┘
                                        │
                    ┌───────────────────┼──────────────────────────┐
                    │                   │              │            │
              ┌─────▼──────┐  ┌─────────▼──┐  ┌──────▼─────┐ ┌───▼──────┐
              │360 MEDIA   │  │DIGITAL     │  │CONSULTING  │ │TRAINING  │
              │PRODUCTION  │  │MARKETING   │  │/consulting │ │/training │
              │/production │  │/digital-   │  │            │ │          │
              │            │  │marketing   │  └────────────┘ └──────────┘
              └────────────┘  └────────────┘
                    │
              ┌─────▼──────┐
              │WEBSITE     │
              │DEVELOPMENT │
              │/web-dev    │
              └────────────┘

  HIDDEN (built, not linked in nav):
  ┌────────────────────────────────────┐
  │  BLOG  /blog                       │
  │  Astro Content Collections         │
  │  Hidden until content is ready     │
  └────────────────────────────────────┘

  FORM HANDLING (server-side, no third party):
  ┌────────────────────────────────────┐
  │  contact.php  (Hostinger server)   │
  │  Receives POST from all forms      │
  │  Sends to @obviusdigital.ca email  │
  └────────────────────────────────────┘
```

---

## Navigation Structure

### Primary Navigation (Header — all pages)
- Home
- About Us
- Services
- Our Work
- Contact Us

Blog is NOT in primary navigation. Exists at `/blog` but not linked until content is ready.

### Footer Navigation (Column 2 — Sitemap)
- Home
- About Us
- Our Work
- Contact Us

### Footer Navigation (Column 3 — Services)
- 360 Media Production
- Digital Marketing
- Consulting
- Training
- Website Development

---

## Page Inventory

### `/` — Home
| Section | Component | Notes |
|---|---|---|
| Header | `Header.astro` | Shared |
| Hero | `HomeHero.astro` | Logo, brand promise, 2 CTAs, work examples |
| Past Clients | `ClientLogos.astro` | Logo strip — placeholders until real logos provided |
| Brand Promise | `BrandPromise.astro` | Paragraph section |
| Our Services | `ServiceTiles.astro` | 5 tiles with View button — links to service pages |
| Why Us | `WhyUsGrid.astro` | Grid of benefit cells |
| Past Work | `PastWork.astro` | 3 cards — logo, brand, tag — placeholders until real content |
| FAQ | `FAQ.astro` | Accordion |
| Client Reviews | `Reviews.astro` | Text-based — Google Reviews placeholder div ready |
| Contact Form | `ContactForm.astro` | Posts to contact.php on Hostinger |
| Footer | `Footer.astro` | Shared — 4-column |

### `/about` — About Us
| Section | Component | Notes |
|---|---|---|
| Header | `Header.astro` | Shared |
| Hero | `PageHero.astro` | Brand promise + graphic |
| About Section | `AboutContent.astro` | 2 paragraphs + video embed |
| How We're Different | `WhyUsGrid.astro` | Reused from Home |
| Founders | `Founders.astro` | Photos, names, titles, socials, message — placeholders for photos |
| Reviews | `Reviews.astro` | Shared |
| Contact Form | `ContactForm.astro` | Shared |
| Footer | `Footer.astro` | Shared |

### `/services` — Services Overview
| Section | Component | Notes |
|---|---|---|
| Header | `Header.astro` | Shared |
| Hero | `PageHero.astro` | "What We Do at Obvius Digital" tagline + graphic |
| Service Tiles | `ServiceTiles.astro` | Reused — 5 tiles linking to individual pages |
| FAQ | `FAQ.astro` | Reused |
| Contact Form | `ServicesContactForm.astro` | Project-specific fields |
| Footer | `Footer.astro` | Shared |

### `/production` `/digital-marketing` `/consulting` `/training` `/web-dev` — Individual Service Pages
| Section | Component | Notes |
|---|---|---|
| Header | `Header.astro` | Shared |
| Hero | `PageHero.astro` | Service name + tagline |
| Service Detail | `ServiceDetail.astro` | Placeholder structure — copy drops in when written |
| Contact Form | `ServicesContactForm.astro` | Shared project-specific form |
| Footer | `Footer.astro` | Shared |

### `/work` — Our Work
| Section | Component | Notes |
|---|---|---|
| Header | `Header.astro` | Shared |
| Hero | `PageHero.astro` | "Our Work" + graphic |
| Past Work | `PastWork.astro` | Reused — 3 cards |
| CTA | `WorkCTA.astro` | "Like What You See?" + Contact button |
| Reviews | `Reviews.astro` | Shared |
| Contact Form | `ContactForm.astro` | Shared |
| Footer | `Footer.astro` | Shared |

### `/contact` — Contact Us
| Section | Component | Notes |
|---|---|---|
| Header | `Header.astro` | Shared |
| Hero | `PageHero.astro` | "Get in Touch" + graphic |
| Contact Info | `ContactInfo.astro` | CTA paragraph + social links |
| Contact Buttons | `ContactButtons.astro` | Phone: +1 416 884 4080 · Email: @obviusdigital.ca · IG: @obviusdigital |
| Contact Form | `ContactForm.astro` | Shared |
| Footer | `Footer.astro` | Shared |

### `/blog` — Blog (Hidden)
| Section | Notes |
|---|---|
| Header | Shared — page NOT linked in nav |
| Blog Index | Astro Content Collections — lists all posts |
| Individual Posts | Generated from `src/content/blog/*.md` |
| Footer | Shared |

---

## Astro Project Structure

```
obvius-digital/
├── public/
│   ├── fonts/
│   │   ├── Rowdies-Bold.ttf
│   │   ├── Rowdies-Regular.ttf
│   │   └── Rowdies-Light.ttf
│   ├── images/
│   │   ├── logo-red-black.png
│   │   ├── logo-red-white.png
│   │   └── eye-mark.png
│   ├── contact.php                 ← PHP form handler — emails to @obviusdigital.ca
│   └── favicon.ico
│
├── src/
│   ├── layouts/
│   │   └── BaseLayout.astro        ← GA tag, font links, shared HTML shell
│   │
│   ├── components/
│   │   ├── Header.astro
│   │   ├── Footer.astro
│   │   ├── ContactForm.astro       ← Posts to /contact.php
│   │   ├── ServicesContactForm.astro
│   │   ├── Reviews.astro           ← Text reviews + Google Reviews placeholder div
│   │   ├── ServiceTiles.astro
│   │   ├── WhyUsGrid.astro
│   │   ├── PastWork.astro
│   │   ├── FAQ.astro
│   │   ├── PageHero.astro
│   │   ├── HomeHero.astro
│   │   ├── ClientLogos.astro
│   │   ├── BrandPromise.astro
│   │   ├── AboutContent.astro
│   │   ├── Founders.astro
│   │   ├── ContactInfo.astro
│   │   ├── ContactButtons.astro
│   │   ├── WorkCTA.astro
│   │   └── ServiceDetail.astro
│   │
│   ├── pages/
│   │   ├── index.astro             ← /
│   │   ├── about.astro             ← /about
│   │   ├── services.astro          ← /services
│   │   ├── work.astro              ← /work
│   │   ├── contact.astro           ← /contact
│   │   ├── production.astro        ← /production
│   │   ├── digital-marketing.astro ← /digital-marketing
│   │   ├── consulting.astro        ← /consulting
│   │   ├── training.astro          ← /training
│   │   ├── web-dev.astro           ← /web-dev
│   │   └── blog/
│   │       ├── index.astro         ← /blog (hidden — no nav link)
│   │       └── [...slug].astro     ← /blog/post-name
│   │
│   ├── content/
│   │   ├── config.ts
│   │   └── blog/
│   │
│   └── styles/
│       ├── global.css
│       ├── layout.css
│       └── components.css
│
├── astro.config.mjs
├── package.json
└── .gitignore
```

---

## Component Reuse Map

| Component | Pages Used |
|---|---|
| `Header.astro` | All pages |
| `Footer.astro` | All pages |
| `ContactForm.astro` | Home, About, Our Work, Contact |
| `Reviews.astro` | Home, About, Our Work |
| `ServiceTiles.astro` | Home, Services |
| `WhyUsGrid.astro` | Home, About |
| `PastWork.astro` | Home, Our Work |
| `FAQ.astro` | Home, Services |
| `PageHero.astro` | About, Services, Our Work, Contact, all service pages |
| `ServicesContactForm.astro` | Services, all 5 individual service pages |

---

## Form Handling — PHP Approach

No third-party service. Form submissions handled entirely on Hostinger.

```
User submits form
       ↓
ContactForm.astro (POST action="/contact.php")
       ↓
contact.php (lives in /public — served at obviusdigital.ca/contact.php)
       ↓
PHP mail() function
       ↓
Delivered to @obviusdigital.ca business email
```

`contact.php` validates input server-side, sends the email, and returns a JSON response. The form handles success/error display client-side.

---

## Third-Party Integrations

| Service | Purpose | Where |
|---|---|---|
| Google Analytics (GA4) | Site tracking | `BaseLayout.astro` — ID placeholder until provided |
| Google Reviews widget | Reviews (future) | `Reviews.astro` — placeholder div ready |
| Rowdies font | Brand typography | `global.css` via `@font-face` + `public/fonts/` |

---

## CSS Architecture

- `global.css` — Reset, CSS variables, body, typography, utility classes
- `layout.css` — Header, navigation, footer, page grid
- `components.css` — All component-level styles per m0t.WEB.1.1 section order

```css
--color-red: #C0392B;
--color-black: #0A0A0A;
--color-white: #FFFFFF;
--color-grey-light: #F5F5F5;
--color-grey-mid: #999999;
--font-primary: 'Rowdies', sans-serif;
```

---

## Version History

| Version | Date | Change |
|---|---|---|
| 01 | March 2026 | Initial creation |
| 02 | March 2026 | Services updated to confirmed 5, domain set to obviusdigital.ca, form handling changed to PHP on Hostinger, contact.php added to project structure, contact details added (phone, IG handle), WordPress replacement noted in site map |
