# Obvius Digital — Full Build Handoff
**For: Antigravity (Agentic Build)**
**Author: Toluwalase Mebaanne**
**Date: March 2026**

---

## READ THIS FIRST

You are being handed a complete, fully documented web project to build from scratch inside an existing Astro project. Everything you need to understand the project is in this document and the five foundation files listed below. Read all of them before writing a single file.

### Foundation Files — Read All of These Before Starting

All files are in the `obvious_build_docs/` folder in the project root:

1. `obvius_web_vision_scope_v02.md` — What is being built, what is in scope, what is deferred, all key decisions
2. `obvius_web_architecture_v02.md` — Every page, every component, every file path, the full project structure
3. `obvius_web_content_inventory_v02.md` — Every content item and its status (ready, derived, missing, deferred)
4. `obvius_web_log.md` — All decisions made so far and their reasoning
5. `obvius_web_sync_protocol_v1_1.md` — How this project is tracked and synced

---

## The Project

**Obvius Digital** is a creative digital agency offering 360 media production, digital marketing, consulting, training, and website development. Their clients are small and medium-sized businesses and startups.

**Brand promise:** More than marketing. A partner in your growth.

**Brand voice:** Mature but agile. Partner-focused. Direct. Intentional. They want clients to feel value, trust, affordability, reliability, and like they have a genuine partner.

**The website's job:** Convert visitors into clients. The homepage carries most of the information load. The contact page is the conversion endpoint.

---

## Tech Stack

- **Framework:** Astro (already initialised — minimal template)
- **Hosting:** Hostinger via GitHub Actions auto-deploy (already configured and working)
- **CSS:** Custom CSS only — no Tailwind, no frameworks
- **Font:** Rowdies (Bold, Regular, Light) — served locally from `public/fonts/`
- **Forms:** PHP script (`contact.php` in `public/`) — posts to Hostinger PHP mail, delivers to business email
- **Analytics:** Google Analytics GA4 — placeholder in BaseLayout, ID to be dropped in later
- **Blog:** Astro Content Collections — built but hidden from navigation

The deploy pipeline is already working. Every push to the `main` branch on GitHub automatically builds and deploys to `obviusdigital.ca`. Do not touch `.github/workflows/deploy.yml`.

---

## Brand Assets

All brand assets are in `public/images/`. Add them there.

- `logo-red-black.png` — horizontal logo, red + black (source: `obvius_digital_logo_Croppedred.PNG`)
- `logo-red-white.png` — horizontal logo, red + white on black (source: `obvius_digital_logored_white.png`)
- `eye-mark.png` — standalone eye icon mark (source: `obvius_eyered.png`)

Font files go in `public/fonts/`:
- `Rowdies-Bold.ttf`
- `Rowdies-Regular.ttf`
- `Rowdies-Light.ttf`

---

## CSS Architecture — Non-Negotiable

Three CSS files only. No inline styles in production. No additional CSS files.

```
src/styles/global.css       ← Reset, CSS variables, body, typography, utilities
src/styles/layout.css       ← Header, navigation, footer, page grid
src/styles/components.css   ← All component-level styles
```

### CSS Variables — All colours and typography defined here

All colours must be defined as CSS variables in `global.css`. This is non-negotiable. Swapping one hex value in the variables must update the entire site globally. No hardcoded colour values anywhere else in any CSS file.

```css
:root {
  /* Brand colours — confirm exact hex before launch */
  --color-red: #C0392B;        /* Primary brand red — PLACEHOLDER, confirm hex */
  --color-black: #0A0A0A;      /* Near-black */
  --color-white: #FFFFFF;
  --color-grey-light: #F5F5F5;
  --color-grey-mid: #999999;

  /* Typography */
  --font-primary: 'Rowdies', sans-serif;

  /* Spacing scale */
  --space-xs: 0.5rem;
  --space-sm: 1rem;
  --space-md: 2rem;
  --space-lg: 4rem;
  --space-xl: 8rem;
}
```

Any additional colours needed for the UI design (hover states, gradients, overlays, etc.) must also be defined as variables here — never hardcoded.

### CSS Section Order (mandatory for every CSS file)

Every CSS file follows this exact section order:
1. General Reset
2. Body styles
3. Typography
4. Header styles
5. Navigation styles
6. Main content styles
7. Component-specific sections
8. Footer styles
9. Form styles
10. Button styles
11. Media Queries
12. Accessibility styles
13. Utility classes

### CSS Property Group Order (mandatory for every rule set)

Within every rule, properties must be grouped in this order with group comments:

```css
.selector {
  /* text */
  /* color */
  /* box model */
  /* border */
  /* display */
  /* positioning */
  /* flexbox */
  /* grid */
  /* transform */
  /* transition */
  /* animation */
  /* cursor */
  /* outline */
  /* other */
}
```

### Section Header Format (mandatory)

Every section must use exactly this format:

```css
/* ===========================
   Section Name
   =========================== */
```

Exactly 27 equal signs on both lines. Count them.

### Mobile First (mandatory)

All CSS is written mobile first. Base styles target mobile. Media queries add complexity upward. Never the reverse.

---

## UI Direction

Design a modern, clean, high-quality website for a digital marketing agency. The brand is professional, confident, and partner-focused — not flashy or gimmicky.

You have full creative freedom on the UI. Make it distinctive and memorable. Use the brand colours (red, black, white) as the foundation. Rowdies is the brand font — use it well. The site should feel like it was designed, not generated.

What to avoid:
- Generic template aesthetics
- Purple gradients
- Overused layout patterns
- Anything that looks like every other agency site

What to aim for:
- Strong typographic hierarchy
- Purposeful use of the red accent
- Clean, confident layouts with generous spacing
- A site that feels like a genuine partner to small businesses, not a faceless service

---

## Project Structure to Build

```
src/
├── layouts/
│   └── BaseLayout.astro
├── components/
│   ├── Header.astro
│   ├── Footer.astro
│   ├── ContactForm.astro
│   ├── ServicesContactForm.astro
│   ├── Reviews.astro
│   ├── ServiceTiles.astro
│   ├── WhyUsGrid.astro
│   ├── PastWork.astro
│   ├── FAQ.astro
│   ├── PageHero.astro
│   ├── HomeHero.astro
│   ├── ClientLogos.astro
│   ├── BrandPromise.astro
│   ├── AboutContent.astro
│   ├── Founders.astro
│   ├── ContactInfo.astro
│   ├── ContactButtons.astro
│   ├── WorkCTA.astro
│   └── ServiceDetail.astro
├── pages/
│   ├── index.astro
│   ├── about.astro
│   ├── services.astro
│   ├── work.astro
│   ├── contact.astro
│   ├── production.astro
│   ├── digital-marketing.astro
│   ├── consulting.astro
│   ├── training.astro
│   ├── web-dev.astro
│   └── blog/
│       ├── index.astro
│       └── [...slug].astro
├── content/
│   ├── config.ts
│   └── blog/
└── styles/
    ├── global.css
    ├── layout.css
    └── components.css
```

`public/` structure:
```
public/
├── fonts/
│   ├── Rowdies-Bold.ttf
│   ├── Rowdies-Regular.ttf
│   └── Rowdies-Light.ttf
├── images/
│   ├── logo-red-black.png
│   ├── logo-red-white.png
│   └── eye-mark.png
├── contact.php
└── favicon.ico
```

---

## Page Sections — Build Each Page Exactly as Specified

### `/` — Home
1. Header
2. Hero — logo, brand promise headline + subtext, 2 CTA buttons ("Request Proposal" and "Learn More"), work examples
3. Past Clients — logo strip (placeholders)
4. Brand Promise — paragraph section
5. Our Services — 5 tiles, one sentence each, View button linking to service page
6. Why Us — grid of benefit cells (header + text each)
7. Past Work — 3 cards (client logo, brand name text, category tag) — placeholders
8. FAQ — accordion
9. Client Reviews — text-based, placeholder div ready for Google Reviews widget
10. Contact Form
11. Footer

### `/about` — About Us
1. Header
2. Hero — brand promise + graphic placeholder
3. About Obvius — 2 paragraphs + 9:16 video embed placeholder
4. How We're Different — same WhyUsGrid component as homepage
5. A Message From the Founders — profile photo placeholders, names, titles, social links, message
6. Client Reviews
7. Contact Form
8. Footer

### `/services` — Services Overview
1. Header
2. Hero — "What We Do at Obvius Digital" + tagline + graphic placeholder
3. Our Services — same ServiceTiles component as homepage
4. FAQ — same FAQ component as homepage
5. Services Contact Form (project-specific fields)
6. Footer

### `/production` `/digital-marketing` `/consulting` `/training` `/web-dev` — Individual Service Pages
1. Header
2. Hero — service name + tagline
3. Service Detail — placeholder content structure (headline, 2-3 paragraph placeholders, deliverables list placeholder)
4. Services Contact Form
5. Footer

### `/work` — Our Work
1. Header
2. Hero — "Our Work" + graphic placeholder
3. Past Work — same 3 cards component
4. Like What You See CTA — short text + button to contact page
5. Client Reviews
6. Contact Form
7. Footer

### `/contact` — Contact Us
1. Header
2. Hero — "Get in Touch With Us" + graphic placeholder
3. Contact Info — CTA paragraph + social media links (Instagram, Facebook, LinkedIn, YouTube)
4. 3 big contact buttons — Phone (+1 416 884 4080), Email (@obviusdigital.ca placeholder), Instagram DM (@obviusdigital)
5. Contact Form
6. Footer

### `/blog` — Hidden
Build the blog index and slug pages using Astro Content Collections. Do NOT link the blog anywhere in navigation. It exists at `/blog` but is invisible in nav until explicitly enabled.

---

## Content to Use

Use everything from `obvius_web_content_inventory_v02.md`. Items marked ✅ Ready or ✅ Derived are confirmed and should be used. Items marked ❌ Missing should use clearly labelled placeholder text.

Key confirmed content:
- **Brand promise:** "More than marketing. A partner in your growth."
- **Brand promise subtext:** "We help small and medium-sized businesses show up with confidence, communicate clearly, and grow intentionally."
- **Founder 1:** Tolu Mebaanne — Co-Founder / Media Production
- **Founder 2:** Kayla Sippel — Co-Founder / Communications & Strategy
- **Phone:** +1 416 884 4080
- **Instagram:** @obviusdigital
- **Service descriptions:** See content inventory for all 5 one-sentence descriptions
- **Why Us cells:** Partner in Growth · Built for Small Business · Reliable & Consistent · Agile to Trends · Identity-Driven Work · Listen → Create → Support

Use `[PLACEHOLDER]` clearly in the code for any missing content so it is easy to find and replace.

---

## contact.php — Form Handler

Create `public/contact.php` to handle all form submissions:

```php
<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);

if (empty($name) || empty($email) || empty($message)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'All fields are required']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid email address']);
    exit;
}

$to = 'hello@obviusdigital.ca';
$subject = 'New enquiry from ' . $name;
$body = "Name: $name\nEmail: $email\n\nMessage:\n$message";
$headers = "From: $email\r\nReply-To: $email\r\n";

if (mail($to, $subject, $body, $headers)) {
    echo json_encode(['success' => true, 'message' => 'Message sent successfully']);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Failed to send message']);
}
?>
```

All contact forms POST to `/contact.php`. Handle the JSON response client-side to show success or error state without page reload.

---

## BaseLayout.astro — Build This First

This is the critical dependency. Nothing else can be built correctly until this is done.

It must contain:
- DOCTYPE, html, head, body structure
- Rowdies font loaded via @font-face from `public/fonts/`
- Google Analytics GA4 script — use placeholder comment `<!-- GA_MEASUREMENT_ID_PLACEHOLDER -->`
- CSS imports (global.css, layout.css, components.css)
- Header and Footer slot
- Default meta tags (title, description, viewport, charset)
- Accepts props: `title`, `description`

---

## Navigation Rules

Primary nav (all pages): Home · About Us · Services · Our Work · Contact Us

Blog is NEVER in the navigation. Not linked anywhere. Build it, but keep it invisible.

Footer column 2 (Sitemap): Home · About Us · Our Work · Contact Us
Footer column 3 (Services): 360 Media Production · Digital Marketing · Consulting · Training · Website Development

Footer is 4 columns:
1. Logo + USP line + email signup CTA + email input field
2. Sitemap links
3. Services links
4. Contact info

---

## What Done Means

- All pages render without errors
- All components render with placeholder content where real content is missing
- Contact forms submit to contact.php and handle success/error response
- Blog exists at /blog but is not linked in navigation
- Google Reviews placeholder div exists in Reviews.astro
- All colours are CSS variables — no hardcoded hex values outside of :root
- CSS follows the section order and property group order specified above
- Mobile first — site is fully responsive across mobile, tablet, desktop
- Rowdies font loads correctly from public/fonts/
- No broken links
- `npm run build` completes without errors

---

## What NOT to Touch

- `.github/workflows/deploy.yml` — deploy pipeline, do not modify
- `obvious_build_docs/` folder — project documentation, do not modify
- `package.json` and `package-lock.json` — do not add dependencies without a clear reason
- `.gitignore` — do not modify

---

## Build Order

Follow this order. Do not skip ahead.

1. `src/styles/global.css` — variables, reset, typography
2. `src/styles/layout.css` — header, footer, grid
3. `src/styles/components.css` — all component styles
4. `src/layouts/BaseLayout.astro` — confirm working before proceeding
5. `src/components/Header.astro`
6. `src/components/Footer.astro`
7. `public/contact.php`
8. `src/components/ContactForm.astro`
9. All remaining components
10. `src/pages/index.astro` — homepage first
11. All remaining pages
12. Blog pages last

Verify `npm run build` completes without errors before considering the build done.
