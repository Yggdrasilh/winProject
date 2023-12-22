<?php

namespace App\Controller;

use App\Entity\Wine;
// use App\Entity\Region;
use App\Form\Type\WineType;
use App\Repository\WineRepository;
use App\Repository\RegionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class WineController extends AbstractController
{
    #[Route('/', name: 'app_wine')]
    public function index(Request $request, WineRepository $winerepo): Response
    {
        $wines = $winerepo->allWine_ThisRegion();

        return $this->render('wine/index.html.twig', [
            'controller_name' => 'WineController', 'wines' => $wines,
        ]);
    }

    #[Route('/add', name: 'app_wine_add')]
    public function add(Request $request, RegionRepository $regionRepo, EntityManagerInterface $entityManager): Response
    {
        $wine = new Wine();
        $regions = $regionRepo->findBy([], ['numero' => 'ASC']);

        $regionsOrdered = [];
        foreach ($regions as $region) {
            $regionsOrdered[$region->getName()] = $region; // Use the Region entity as the value
        }

        $form = $this->createForm(WineType::class, $wine)
            ->add('region', ChoiceType::class, [
                'label' => 'Region :',
                'choices' => $regionsOrdered,
                'choice_label' => 'name', // Assuming Region entity has a "name" property
            ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $wine = $form->getData();

            // At this point, $wine->getRegion() will return the selected Region entity

            $entityManager->persist($wine);
            $entityManager->flush();

            // Redirect to the desired route after successful form submission
            return $this->redirectToRoute('app_wine');
        }

        return $this->render('wine/add.html.twig', [
            'controller_name' => 'ArticleController',
            'form' => $form->createView(),
        ]);
    }
}
