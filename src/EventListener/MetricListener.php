<?php

namespace App\EventListener;

use Prometheus\CollectorRegistry;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\RequestEvent;

#[AsEventListener]
class MetricListener {

    public function __invoke(RequestEvent $event): void {

        $request = $event->getRequest();
        $route = $request->getRequestUri();
        $method = $request->getMethod();

        if ($event->isMainRequest() && ! str_starts_with($route, '/_wdt')) {
            // Un compteur tout simple qui s'incrémente à chaque fois qu'on passe ici
            // Prise en charge automatique de la métrique via un évènement du controller
            $registry = CollectorRegistry::getDefault();
            $counter = $registry->getOrRegisterCounter(
                'sampleapp',
                'request_total_labels',
                'Total number of requests made', ['route', 'method']
            );
            $counter->incBy(1, [$route, $method]);
        }
    }
}