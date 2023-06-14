<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../../wp-load.php';
require_once "includes/db.php";

/** Sets up the WordPress Environment. */
define('WP_USE_THEMES', false); /* Disable WP theme for this file (optional) */

const YOUINPAINT_WIDHT = 500;
const YOUINPAINT_HEIGHT = 500;

// TODO: Afegir la funcionalitat restant...
//...