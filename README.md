# Deploying Auxegen Funding (cheapest path — $0/month)

**Stack:** GitHub Pages (free hosting) + Cloudflare Worker (free form backend) +
your existing Squarespace domain (just add DNS records). Free SSL/HTTPS on both.
Total ongoing cost: $0 on top of the domain you already pay for.

---

## Part 1 — Put the site on GitHub Pages

1. Create a free account at github.com.
2. Click **New repository**. Name it (e.g. `auxegen-site`), set it **Public**, create it.
3. Upload the site files: on the repo page choose **Add file → Upload files**, then drag
   in everything *inside* the `auxegen-funding-website` folder (so `index.html` sits at the
   repo root, not inside a subfolder). Commit.
4. Go to **Settings → Pages**. Under **Build and deployment**, Source = **Deploy from a
   branch**, Branch = **main**, folder = **/ (root)**. Save.
5. Wait ~1 minute. A temporary URL appears (e.g. `https://YOURNAME.github.io/auxegen-site/`).
   Open it to confirm the site works.

## Part 2 — Connect your domain (Squarespace DNS)

1. In GitHub: **Settings → Pages → Custom domain**, enter `auxegenfund.com`, Save.
   (GitHub creates a `CNAME` file in your repo automatically.)
2. In Squarespace: **Domains → auxegenfund.com → DNS → DNS Settings → Custom Records**.
3. Add **four A records** (Host `@`, Type `A`), one for each GitHub Pages IP:
   - `185.199.108.153`
   - `185.199.109.153`
   - `185.199.110.153`
   - `185.199.111.153`
4. Add **one CNAME record**: Host `www`, Type `CNAME`, Data `YOURNAME.github.io`
   (use your GitHub username; keep the trailing `.github.io`).
5. Remove any **default Squarespace A record on `@`** that conflicts (Squarespace parking).
   ⚠️ Do **not** delete `MX` records or anything email-related — that's your
   `info@auxegenfund.com` mail. Leave those alone.
6. DNS can take 24–48 hours to propagate. Once it resolves, return to **GitHub →
   Settings → Pages** and tick **Enforce HTTPS**.

## Part 3 — Make the application form work (Cloudflare Worker)

GitHub Pages can't run PHP, so the form uses a tiny free Cloudflare Worker instead.

1. Create a free account at cloudflare.com.
2. **Workers & Pages → Create → Create Worker**. Give it a name
   (e.g. `auxegen-lead-proxy`), deploy the starter, then **Edit code**, delete the sample,
   and paste in the contents of `server/cloudflare-worker.js`. **Deploy.** Copy the
   Worker URL (e.g. `https://auxegen-lead-proxy.YOURNAME.workers.dev`).
3. In the Worker's **Settings → Variables and Secrets**, add:
   - `STARTCAP_API_KEY` = your real StartCap key  — **type: Secret (Encrypt)**
   - `ALLOWED_ORIGIN` = `https://auxegenfund.com`  — type: plaintext
4. In your repo, edit **`config.js`**:
   ```js
   window.AUXEGEN_LEAD_ENDPOINT = "https://auxegen-lead-proxy.YOURNAME.workers.dev";
   ```
   Commit. GitHub Pages redeploys automatically in ~1 minute.
5. Open `apply.html` on your live site and submit a test. You should get a confirmation
   with a reference number. (Tip: while testing, you can point the Worker at StartCap's
   `/leads/validate` endpoint, which checks data without creating a real lead.)

The StartCap API key lives **only** as a Worker secret — never in the website files or the
repo. The Cloudflare free plan's daily request allowance is far beyond what a lead form uses.

---

## Alternatives (also free)

- **Cloudflare Pages** instead of GitHub Pages — host the site and the Worker in one
  Cloudflare account. (Requires pointing your domain's nameservers to Cloudflare.)
- **Netlify** free tier — can host the static site *and* run the form as a Netlify Function,
  so you wouldn't need a separate Worker. Ask and I can provide that function file.
- **A cheap PHP host** (e.g. shared cPanel hosting, a few $/month) — then `lead-proxy.php`
  works directly, no Worker needed, and `config.js` stays as `"lead-proxy.php"`.

## After launch — content still to finalize

Search the HTML for `EDIT ME`: home-page stat figures and testimonials (use real,
permission-based quotes), and the About story. Everything else (contact info, hours,
funding figures) is already set.
