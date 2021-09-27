<?php

namespace App\Controller;

use App\Entity\Personne;
use App\Repository\PersonneRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class APIController extends AbstractController
{
    /**
     * @Route("/api/personne/", name="api_liste_personnne" ,methods={"GET"})
     */
    public function index(PersonneRepository $repo): Response
    {
        //$tab["message"]= "Liste de Personnes";
        return $this->json($repo->findAll());
    }

    /**
     * @Route("/api/personne/ajouter", name="api_add_personnne" ,methods={"POST"})
     */
    public function ajouter(Request $request,EntityManagerInterface $em): Response
    {
        // je dois recupérer 1 nom et 1 prenom
        // { "nom":"WILLIS" , "prenom":"Bruce"}
        $json =$request->getContent();
        // transformer en objet PHP
        $obj = json_decode($json);
        $categ= $obj->categ;
        //print_r($categ);

        $personne  = new Personne();
        // hydrater
        $personne->setNom($obj->nom);
        $personne->setPreNom($obj->prenom);
        $em->persist($personne);
        $em->flush();
        //$tab["message"]= "Ajouter de Personnes";
        return $this->json($personne);
    }

    /**
     * @Route("/api/personne/supprimer", name="api_remove_personnne" ,methods={"POST"})
     */
    public function remove(Request $request,EntityManagerInterface $em, PersonneRepository $repo): Response
    {
        // je dois recupérer 1 nom et 1 prenom
        // { "nom":"WILLIS" , "prenom":"Bruce"}
        $json =$request->getContent();
        // transformer en objet PHP
        $obj = json_decode($json);
        //print_r($categ);
        // hydrater
        $id = $obj->id;
        $personne = $repo->findOneBy(
            [
                'id'=>$id
            ]
        );
        $em = $this->getDoctrine()->getManager();
        $em->remove($personne);
        $em->flush();
        //$tab["message"]= "Ajouter de Personnes";
        return $this->json($personne);
    }

    /**
     * @Route("/api/personne/modifier", name="api_modify_personnne" ,methods={"POST"})
     */
    public function modify(Request $request,EntityManagerInterface $em, PersonneRepository $repo): Response
    {
        // je dois recupérer 1 nom et 1 prenom
        // { "nom":"WILLIS" , "prenom":"Bruce"}
        $json =$request->getContent();
        // transformer en objet PHP
        $obj = json_decode($json);
        //print_r($categ);
        // hydrater
        $id = $obj->id;
        $nom = $obj->nom;
        $prenom = $obj->prenom;
        $personne = $repo->findOneBy(
            [
                'id'=>$id
            ]
        );
        if($nom != null) $personne->setNom($nom);
        if($prenom != null) $personne->setPrenom($prenom);
        $em = $this->getDoctrine()->getManager();
        $em->persist($personne);
        $em->flush();
        //$tab["message"]= "Ajouter de Personnes";
        return $this->json($personne);
    }
}
