<?php

/**
 * Load .env file
 *
 * @param string $path
 */
function loadDotEnv(string $path)
{
    if (!file_exists($path)) die("Impossible de charger les variables d\'environnements : le fichier ${path} n\'existe pas");

    $env = fopen($path, 'r');
    if (empty($env)) die("Impossible d'ouvrir ${path} : le fichier est vide ou n'est pas accessible");

    while (!feof($env)) {
        $line = trim(fgets($env));
        $preg_results = [];
        if (preg_match('/([^=]*)=([^#]*)/', $line, $preg_results) && !empty($preg_results[1]) && !empty($preg_results[2])) {
            define($preg_results[1], $preg_results[2]);
        }
    }
}
