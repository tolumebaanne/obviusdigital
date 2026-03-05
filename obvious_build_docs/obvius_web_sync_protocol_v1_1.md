# Obvius Digital Website — Project Sync Protocol
**Author: Toluwalase Mebaanne**
**Version: 1.1**
**Purpose: Defines exactly how any agent synchronizes with this project at the start of every session and on every #sync trigger.**
**Created: March 2026**

---

## Core Principle

A sync is only complete when the agent can answer these five questions without guessing:

1. What pages and components are built and working right now?
2. What is broken, incomplete, or blocked?
3. What was the last thing worked on and what is its current state?
4. What decisions have been made that affect what comes next?
5. What content is still missing and what has been deferred?

If any of these cannot be answered with confidence, the sync is not complete. Search more. Read more. Then deliver the summary.

---

## When to Execute

- At the start of every new session on this project
- Every time `#sync` is triggered
- When uncertain about current project state
- Never skip — even if the last session ended recently

---

## Phase 1: Read All Project Documents

Read these in priority order before searching conversations.

**Priority 1 — Must read every sync:**
- `obvius_web_log_updated.md` — Current state, all decisions, issues, deferrals
- `obvius_web_sync_protocol_v01.md` — This document

**Priority 2 — Read if present:**
- `obvius_web_vision_scope_v02.md` — What is in and out of scope (use v02, supersedes v01)
- `obvius_web_architecture_v02.md` — Page map, component list, file structure (use v02, supersedes v01)
- `obvius_web_content_inventory_v02.md` — What content exists vs what is missing (use v02, supersedes v01)

**Priority 3 — Scan and read if relevant:**
- Any newer versioned documents (v03 and beyond) — always use the highest version
- Any component-specific notes added during build

---

## Phase 2: Search Past Conversations

Run these searches in order.

**Set A — Project activity**
```
conversation_search("Obvius Digital website built")
conversation_search("Obvius Digital component completed")
conversation_search("Obvius Digital confirmed working")
conversation_search("Obvius Digital session ended")
conversation_search("obviusdigital.ca")
```

**Set B — Problems and issues**
```
conversation_search("Obvius Digital error")
conversation_search("Obvius Digital broken")
conversation_search("Obvius Digital not working")
conversation_search("Astro Hostinger deploy")
conversation_search("contact.php error")
```

**Set C — Decisions and direction**
```
conversation_search("Obvius Digital decided")
conversation_search("Obvius Digital deferred")
conversation_search("Obvius Digital content provided")
conversation_search("PHP mail Obvius")
conversation_search("Rowdies font Obvius")
```

**Set D — Component and page status**
```
conversation_search("Obvius BaseLayout")
conversation_search("Obvius Header Footer")
conversation_search("Obvius homepage built")
conversation_search("Obvius contact page")
conversation_search("Obvius services page")
conversation_search("Obvius blog hidden")
```

**Set E — Grows with the project**

*Add searches here as new workstreams begin.*

When content population begins: add `conversation_search("Obvius content added")`
When CSS finalised: add `conversation_search("Obvius CSS variables confirmed")`
When PHP form tested: add `conversation_search("contact.php tested Obvius")`
When GA configured: add `conversation_search("Google Analytics Obvius G-")`
When Hostinger email set up: add `conversation_search("obviusdigital.ca email")`
When launch prep begins: add `conversation_search("Obvius launch deploy")`

---

## Phase 3: Reconcile

- Does the project log reflect what the conversations confirm?
- Are there decisions made in conversation not yet in the log?
- Is the content inventory current with what has actually been provided?
- Are there unresolved issues from the last session?

If gaps exist — note in the sync summary.

---

## Phase 4: Deliver the Sync Summary

```
SYNC SUMMARY — Obvius Digital Website (obviusdigital.ca)
Date: [today's date]

PAGES STATUS:
- / (Home): [built | in progress | not started]
- /about: [built | in progress | not started]
- /services: [built | in progress | not started]
- /work: [built | in progress | not started]
- /contact: [built | in progress | not started]
- /production: [built | in progress | not started]
- /digital-marketing: [built | in progress | not started]
- /consulting: [built | in progress | not started]
- /training: [built | in progress | not started]
- /web-dev: [built | in progress | not started]
- /blog: [built-hidden | in progress | not started]

SHARED COMPONENTS:
- BaseLayout.astro: [done | in progress | not started]
- Header.astro: [done | in progress | not started]
- Footer.astro: [done | in progress | not started]
- ContactForm.astro: [done | in progress | not started]
- contact.php: [done | in progress | not started]
- Reviews.astro: [done | in progress | not started]
- [other components as built]

LAST WORKED ON:
[What was the last task and what state did it end in]

BROKEN / BLOCKED:
[Any unresolved issues — or "None"]

CONTENT RECEIVED SINCE LAST SYNC:
[Any new content provided — or "None"]

OPEN DECISIONS:
[Anything requiring Tolu's input — or "None"]

READY TO PROCEED WITH:
[What makes sense to work on next]
```

---

## Phase 5: Wait for Direction

Deliver the sync summary then ask: "What do you want to work on?"

Wait. Do not begin anything until direction is given.

---

## The Rules

1. **Never begin work without completing the sync first** in a new session.
2. **The log is the source of truth.** Conversations supplement it. If they conflict, surface the conflict.
3. **Always use the highest version of every document.** v02 supersedes v01. v03 supersedes v02.
4. **Content inventory is updated when content is received.** Update immediately — do not wait to be asked.
5. **m0t.WEB.1 CSS standard applies to every CSS file.** No exceptions. Run the pre-submission checklist before any CSS is considered done.
6. **One step at a time per m0t.OPERATOR.3.3.** Build one component or page section. Confirm. Then proceed.
7. **Blog is hidden.** Never appears in navigation until Tolu explicitly instructs it.
8. **Rule 8 — Critical Dependency:** `BaseLayout.astro` is built first. The GA script placeholder, Rowdies font loading, and shared HTML shell all live there. No page can be built correctly until `BaseLayout.astro` is confirmed complete. Flag this status in every sync summary until marked resolved.
9. **Rule 9 — Form Dependency:** `contact.php` must be tested with a real form submission on Hostinger before any page with a contact form is considered done. A form that looks correct but has not been tested end-to-end is not done.

---

## Relationship to Other Documents

- This document reads: `obvius_web_log_updated.md`, `obvius_web_vision_scope_v02.md`, `obvius_web_architecture_v02.md`, `obvius_web_content_inventory_v02.md`
- This document is governed by: `m0t_base_protocol_v2_3.md` — specifically m0t.OPERATOR.6 and m0t.OPERATOR.7
- This document does not override the bible. The bible takes precedence on any behavioral question.

---

## Version History

| Version | Date | Change |
|---|---|---|
| 1.0 | March 2026 | Initial creation |
| 1.1 | March 2026 | Domain updated to obviusdigital.ca. Form handling updated to PHP on Hostinger — contact.php added to component status in sync summary. Rule 9 added for form testing dependency. Search sets updated with domain and PHP-specific terms. Document versions updated to v02 references. |
