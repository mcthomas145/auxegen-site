<?php
/**
 * Auxegen Funding -> StartCap lead proxy
 * ---------------------------------------------------------------
 * The application form (apply.html) POSTs JSON here. This script
 * adds your SECRET StartCap API key and forwards the request to
 * StartCap, then returns StartCap's JSON response to the browser.
 *
 * WHY THIS EXISTS: your API key must never live in the web page,
 * or anyone could view-source and steal it. It lives only here,
 * on the server.
 *
 * SETUP (one time):
 *   1. Upload this file to the SAME folder as apply.html.
 *   2. Set your API key as an environment variable named
 *      STARTCAP_API_KEY (recommended). On most cPanel/Apache hosts
 *      you can add this line to a .htaccess file in this folder:
 *          SetEnv STARTCAP_API_KEY your_real_api_key_here
 *      (Get the key from your StartCap partner dashboard ->
 *       API Integration.)
 *   3. Make sure your site is served over HTTPS.
 *
 * If you can't set an env var, you may paste the key into
 * $FALLBACK_KEY below as a last resort -- but prefer the env var.
 * ---------------------------------------------------------------
 */

header('Content-Type: application/json');

// Only accept POST from your own site.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

// --- API key (env var preferred) ---
$apiKey = getenv('STARTCAP_API_KEY');
$FALLBACK_KEY = ''; // optional last resort; leave blank if using env var
if (!$apiKey && $FALLBACK_KEY !== '') { $apiKey = $FALLBACK_KEY; }
if (!$apiKey) {
    http_response_code(500);
    echo json_encode(['error' => 'Server is not configured: missing StartCap API key.']);
    exit;
}

// --- Read and lightly sanity-check the incoming JSON ---
$raw  = file_get_contents('php://input');
$data = json_decode($raw, true);
if (!is_array($data)) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid request.']);
    exit;
}

// Only forward the fields StartCap expects (allowlist).
$allowed = [
    'first_name','last_name','date_of_birth','email','phone','company_name',
    'residential_street','residential_city','residential_state','residential_zip',
    'funding_types','notes','utm_source','utm_medium','utm_campaign','utm_term','utm_content'
];
$payload = [];
foreach ($allowed as $f) {
    if (isset($data[$f]) && $data[$f] !== '') { $payload[$f] = $data[$f]; }
}

// --- Forward to StartCap ---
$ch = curl_init('https://www.startcap.org/app/partners/api/v1/leads/submit');
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => json_encode($payload),
    CURLOPT_HTTPHEADER     => [
        'Content-Type: application/json',
        'X-API-Key: ' . $apiKey,
    ],
    CURLOPT_TIMEOUT        => 25,
]);
$response = curl_exec($ch);
$code     = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$err      = curl_error($ch);
curl_close($ch);

if ($response === false) {
    http_response_code(502);
    echo json_encode(['error' => 'Could not reach the funding service. Please try again.']);
    exit;
}

// Pass StartCap's status code and JSON straight back to the browser.
http_response_code($code ?: 200);
echo $response;
