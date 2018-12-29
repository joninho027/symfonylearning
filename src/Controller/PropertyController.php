<?php

namespace App\Controller;

use App\Repository\PropertyRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Property;

class PropertyController extends AbstractController
{
    /**
     *
     * @var PropertyRepository
     */
    private $repository;
    
    public function __construct(PropertyRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
    * @Route("/biens", name="property.index")
    */
    public function index(): Response {
        
//        $property = new Property();
//        $property->setTitle('Premier bien')
//                ->setPrice(200000)
//                ->setRooms(4)
//                ->setBedrooms(3)
//                ->setDescription('descr')
//                ->setSurface(60)
//                ->setFloor(4)
//                ->setHeat(1)
//                ->setCity('Lille')
//                ->setAddress('87 rue Massena')
//                ->setPostalCode('59800');
//        $em = $this->getDoctrine()->getManager();
//        $em->persist($property);
//        $em->flush();
        
        $property = $this->repository->findAllVisible();
        dump($property);
        return $this->render('properties/index.html.twig', ['current_menu' => 'properties']);
    }

    /**
     * @Route("/biens/{slug}-{id}", name="property.show", requirements={"slug": "[a-z0-9\-]*"})
     * @return Response
     */
    public function show($slug, $id): Response
    {

        $property = $this->repository->find($id);

        if ( $property->getSlug() === $slug )
        {
            return $this->render('properties/show.html.twig', [
                'current_menu' => 'properties',
                'property' => $property
            ]);
        }
        else
        {
            return $this->redirectToRoute('property.show', [
               'id' => $property->getId(),
               'slug' => $property->getSlug()
            ], 301);
        }


    }
}