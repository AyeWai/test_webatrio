<?php

namespace App\Service;

use App\Entity\Personne;
use App\Repository\PersonneRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Doctrine\ORM\EntityRepository;

class PersonneService extends AbstractController{

    public function persistPersonne(Request $request, ValidatorInterface $validator, EntityRepository $em) : Response{
        $entityManager = $em->getEntityManager();

        $firstname = $request->request->get('inputNom');
        $lastname = $request->request->get('inputPrenom');
        $date = $request->request->get('inputDateNaissance');
        $date2 = new \DateTime($date);

        $Personne = new Personne();
        $Personne->setNom($firstname);
        $Personne->setPrénom($lastname);
        $Personne->setDatedenaissance($date2);

        $errors = $validator->validate($Personne);
        if (count($errors) > 0) {
            $errors2 = $errors[0]->getMessage();
            //return new Response((string) $errors, 400);
            return $this->render('personne/new.html.twig', [
                'errors' => $errors2,
                'personne_check' => '',
        ]);
        }
        elseif(count($errors) == 0){


            // tell Doctrine you want to (eventually) save the Product (no queries yet)
            $entityManager->persist($Personne);

            // actually executes the queries (i.e. the INSERT query)
            $entityManager->flush();

            return $this->render('personne/new.html.twig',[
                'errors' => '',
                'personne_check' => 'Nouvelle personne bien enregistrée',
            
        ]);
        }
    }


    public function getPersonnes(PersonneRepository $personneRepository): Response{

        /*$personne = $this->getDoctrine()
            ->getRepository(Personne::class)
            ->find($id);
        if (!$personne) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }
        return $this->render('personne/display.html.twig',[
            'personne' => $personne,
        ]);*/

        $personnes = $personneRepository
            ->findAll();

        return $this->render('personne/display.html.twig',[
            'personnes' => $personnes,
        ]);
    }

    
        //return new Response('Check out this great product: '.$product->getName());

        // or render a template
        // in the template, print things with {{ product.name }}
        // return $this->render('product/show.html.twig', ['product' => $product]);

}
