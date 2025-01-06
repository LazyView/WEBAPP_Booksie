<?php
header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com; style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com https://cdn.lineicons.com https://fonts.googleapis.com; font-src 'self' https://cdn.lineicons.com https://fonts.gstatic.com; img-src 'self' data: https://cdn.jsdelivr.net https://cdn.lineicons.com; connect-src 'self'; frame-src 'none'");
header("X-XSS-Protection: 1; mode=block");
header("X-Frame-Options: DENY");
header("X-Content-Type-Options: nosniff");
header("Referrer-Policy: strict-origin-when-cross-origin");
// Add these additional security headers
header("X-XSS-Protection: 1; mode=block");
header("X-Frame-Options: DENY");
header("X-Content-Type-Options: nosniff");
header("Referrer-Policy: strict-origin-when-cross-origin");

use kivweb\ApplicationStart;
require_once ("MyAutoloader.inc.php");
require_once ("settings.inc.php");

// spustim aplikaci
$app = new ApplicationStart();
$app->appStart();