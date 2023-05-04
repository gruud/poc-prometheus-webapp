<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RouteController {

    #[Route('/myapp/{route}', 'dynamic_route')]
    public function doStuff(Request $request, $route) {
        return new Response('<html lang="fr"><head><title>Test</title></head><body>Passage par la route ' . $route . '</body></html>');
    }
}