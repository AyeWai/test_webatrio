<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Service\PersonneService;
use App\Repository\PersonneRepository;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Doctrine\ORM\EntityRepository;

class PersonneController extends AbstractController
{
        /**
     * @Route("/personne", name="personne")
     */
    public function index(): Response
    {

        return $this->render('personne/index.html.twig');
    }

    /**
     * @Route("/personne-register", name="personne_register")
     */
    public function createPersonne(Request $request, ValidatorInterface $validator, PersonneService $personneService, EntityRepository $em) : Response
     {
        return $personneService->persistPersonne($request, $validator, $em);
              
     }

     /**
     * @Route("/personne-display", name="personne_display")
     */
     public function displayPersonne(Request $request, PersonneService $personneService, PersonneRepository $personneRepository) : Response
     {
        return $personneService->getPersonnes($personneRepository);
              
     }
}
