<?php

/**
 * Load .env file
 *
 * @param string $path
 * @throws Exception
 */
function loadDotEnv(string $path)
{
    if (!file_exists($path)) {
        throw new Exception('Impossible de charger les variables d\'envionnements : le fichier ' . $path . ' n\'existe pas');
    }

    if (empty($env = fopen($path, 'r'))) return;

    while (!feof($env)) {
        $line = trim(fgets($env));
        $preg_results = [];
        if (preg_match('/([^=]*)=([^#]*)/', $line, $preg_results) && !empty($preg_results[1]) && !empty($preg_results[2])) {
            define($preg_results[1], $preg_results[2]);
        }
    }
}
