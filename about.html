# Auxegen Funding — Website

A static, multi-page marketing site for Auxegen Funding, a business funding broker.
Pure HTML/CSS/JS — no build step. Includes a StartCap lead-application form with a
secure server proxy (PHP and Cloudflare Worker versions provided).

## Pages

| File | Purpose |
| --- | --- |
| `index.html` | Home — hero, trust stats, product teaser, testimonials |
| `funding.html` | Funding — Business & Personal products in tabbed cards (dark theme) |
| `about.html` | About — story and values |
| `faq.html` | FAQ |
| `contact.html` | Contact details + inquiry form |
| `apply.html` | Secure StartCap application form |

Other files: `config.js` (form endpoint), `favicon.png`, `apple-touch-icon.png`,
`robots.txt`, `sitemap.xml`, `assets/` (logo variants), `server/` (Cloudflare Worker),
`lead-proxy.php` (PHP proxy).

## Quick start (local preview)

Just open `index.html` in a browser. To preview with a local server (so relative
paths behave exactly like production):

```bash
python3 -m http.server 8080   # then visit http://localhost:8080
```

## Deploying

### Option A — GitHub Pages (static) + Cloudflare Worker for the form  ← recommended free combo

1. Push this folder to a GitHub repo.
2. Repo **Settings → Pages** → Source: `Deploy from a branch`, Branch: `main` / `/root`.
3. (Optional custom domain) In **Settings → Pages → Custom domain**, enter
   `auxegenfund.com` and follow the DNS steps. GitHub will create a `CNAME` file for you.
4. **The form needs a server** (GitHub Pages can't run PHP). Set up the Cloudflare
   Worker in `server/cloudflare-worker.js` (instructions are in that file), then edit
   `config.js`:

   ```js
   window.AUXEGEN_LEAD_ENDPOINT = "https://auxegen-lead-proxy.YOURNAME.workers.dev";
   ```

### Option B — PHP hosting (cPanel, etc.)

1. Upload everything to your web root.
2. Provide your StartCap API key to `lead-proxy.php` as an environment variable.
   On most Apache/cPanel hosts, add a `.htaccess` file in the same folder:

   ```
   SetEnv STARTCAP_API_KEY your_real_api_key_here
   ```
3. Leave `config.js` as `window.AUXEGEN_LEAD_ENDPOINT = "lead-proxy.php";`

Either way: **serve the site over HTTPS** — the form collects personal information.

## The lead form (StartCap API)

- The form on `apply.html` posts JSON to the endpoint in `config.js`.
- The proxy (Worker or PHP) adds your secret `X-API-Key` and forwards to
  `https://www.startcap.org/app/partners/api/v1/leads/submit`.
- **Never put the API key in the website files.** It lives only as a Worker secret
  or a server environment variable. `.gitignore` already excludes `.env`, `*.key`,
  and `.htaccess` so a key can't be committed by accident.
- Funding-type names sent to StartCap must match its accepted values
  (e.g. `Business Term Loan`, `Business Line of Credit`, `Business Credit Stacking`).
- Tip: test against StartCap's `/leads/validate` endpoint first — it checks data
  without saving anything.

## Editing content

Search the HTML for `EDIT ME` to find the placeholders that still need your real info:

- **Stat figures** on the home page (`$250M+`, `7,500+`, etc.) — `index.html`
- **Testimonials** — replace with real, permission-based quotes — `index.html`
- **About story** — `about.html`

Already set to your real details: business name, phone (463.215.6009),
email (info@auxegenfund.com), hours (Mon–Fri 9am–5pm), location (Fishers, IN),
and all funding figures on the Funding page.

## Logos

- `favicon.png`, `apple-touch-icon.png` — browser tab / mobile icon
- `assets/logo-white.png` — white logo for dark backgrounds
- `assets/logo-black.png` — black logo for light backgrounds
- The header/footer logos are embedded directly in the HTML, so the site is
  self-contained even without the `assets/` files.

## Notes

- The footer disclosure is a starting point, not legal advice — have your
  compliance counsel review it before launch.
- © Auxegen Funding. All rights reserved.
