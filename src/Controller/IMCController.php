<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function Symfony\Component\Translation\t;

class IMCController extends AbstractController
{
    /**
     * @Route("/api/imc/savoirAQuelPointJeSuisUnGrosTas", name="api_imc" ,methods={"POST"})
     */
    public function index(Request $request): Response
    {
        // je dois recupérer 1 nom et 1 prenom
        // { "nom":"WILLIS" , "prenom":"Bruce"}
        $json =$request->getContent();
        // transformer en objet PHP
        $obj = json_decode($json);
        $taille = $obj->taille;
        $poids = $obj->poids;
        $imc = $poids / ($taille*$taille);
        $message = "";
        if ($imc < 18.5) {
            $message = "Maigre";
        } else if ( $imc > 25 ) {
            $message = "Surpoids";
        } else {
            $message = "Normal";
        }

        //$tab["message"]= "Ajouter de Personnes";
        return $this->json($message);
    }
}
