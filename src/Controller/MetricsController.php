<?php  
// src/Controller/LuckyController.php 
namespace App\Controller; 
 
use Symfony\Component\HttpFoundation\Response; 
use Symfony\Component\Routing\Annotation\Route; 
use Prometheus\CollectorRegistry; 
use Prometheus\RenderTextFormat; 
 
class MetricsController 
{ 
    #[Route('/metrics')] 
    public function hello(): Response 
    { 
        
        // Un compteur tout simple qui s'incrémente à chaque fois qu'on passe ici 
        $registry = CollectorRegistry::getDefault(); 
        $renderer = new RenderTextFormat(); 
        $result = $renderer->render($registry->getMetricFamilySamples()); 
        
 
        $response = new Response($result); 
        $response->headers->set('Content-Type', 'text/plain'); 
        return $response; 
        
    } 
}

