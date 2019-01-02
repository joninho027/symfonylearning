<?php

namespace App\Controller\Admin;

use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class AdminPropertyController extends AbstractController {

    /**
     * @var PropertyRepository
     */
    private $repository;

    /**
     * AdminPropertyController constructor.
     * @param PropertyRepository $repository.c
     */
    public function __construct(PropertyRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route("/admin", name="admin.property.index")
     */
    public function index()
    {
        $properties = $this->repository->findAll();
        return $this->render('admin/properties/index.html.twig', [
            'properties' => $properties
        ]);
    }

    /**
     * @Route("/admin/{id}", name="admin.property.edit")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit($id)
    {
        $property = $this->repository->find($id);
        $form = $this->createForm(PropertyType::class, $property);

        return $this->render('admin/properties/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }
}