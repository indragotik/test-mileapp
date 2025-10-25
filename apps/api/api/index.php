<?php
// if (isset($_GET['path'])) {
//     $incoming = '/' . ltrim($_GET['path'], '/');

//     // Pastikan path memuat prefix /api
//     if (! str_starts_with($incoming, '/api')) {
//         $path = '/api' . $incoming;
//     } else {
//         $path = $incoming;
//     }

//     // Tangani query string lain (hapus parameter 'path')
//     $originalQuery = $_SERVER['QUERY_STRING'] ?? '';
//     parse_str($originalQuery, $qs);
//     unset($qs['path']);
//     $qsString = http_build_query($qs);

//     $_SERVER['REQUEST_URI'] = $path . ($qsString ? '?' . $qsString : '');
//     $_SERVER['PATH_INFO'] = $path;
//     $_SERVER['QUERY_STRING'] = $qsString;
// }

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . "/../public/index.php";