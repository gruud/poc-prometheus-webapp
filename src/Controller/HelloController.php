<?php 
// src/Controller/LuckyController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Prometheus\CollectorRegistry;

class HelloController
{
    #[Route('/hello')]
    public function hello(): Response
    {
	    // On retient l'heure de début de la requête
	    $startTime = microtime(true);

            // Un compteur tout simple qui s'incrémente à chaque fois qu'on passe ici
            $registry = CollectorRegistry::getDefault();
            $counter = $registry->getOrRegisterCounter('sampleapp', 'request_total', 'Access to route', ['route']);
            $counter->incBy(1, ['hello']);

	    // Une jauge pour contenir le timestamp de l'appel, qui donnera le dernier appel au service
	    $gauge = $registry->getOrRegisterGauge('sampleapp', 'request_last_time_seconds', 'Last Access to route Timestap', ['route']);
	    $gauge->set((new \DateTime())->getTimestamp(), ['hello']);


	    // Durée aléatoire de la requête, entre 10 et 300 ms
	    $time = rand(10, 300) * 1000;

	    usleep($time);
	    $duration = microtime(true) - $startTime;
	    // Un sommaire
	    $summary = $registry->getOrRegisterSummary('sampleapp', 'request_latency_seconds', 'Average summary latency', ['route']);
	    $summary->observe($duration, ['hello']);

	    // Un histogramme
	    $histogram = $registry->getOrRegisterHistogram('sampleapp', 'request_latency_hist_seconds', 'Time for a request', ['route']);
	    $histogram->observe($duration, ['hello']);


        return new Response(
            '<html><body>Helloi - durée ' . ($time / 1000) . 'ms.</body></html>'
        );
    }
}

