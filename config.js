/* Auxegen Funding — site configuration
 * --------------------------------------------------------------
 * Set the URL that receives lead-application submissions:
 *   • PHP hosting (cPanel, etc.): keep "lead-proxy.php" (included)
 *   • GitHub Pages / any static host: use your Cloudflare Worker URL,
 *     e.g. "https://auxegen-lead-proxy.YOURNAME.workers.dev"
 * The API key is NEVER stored here — it lives on the server/worker.
 * -------------------------------------------------------------- */
window.AUXEGEN_LEAD_ENDPOINT = "https://auxegen-lead-proxy.matt-c78.workers.dev";
