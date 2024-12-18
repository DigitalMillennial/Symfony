<?php

namespace App\Controller;

use App\Repository\ArtistRepository;
use App\Repository\DiscRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    private $artistRepo;

    public function __construct(ArtistRepository $artistRepo)
    {
        $this->artistRepo = $artistRepo;
    }

    #[Route('/accueil', name: 'app_accueil')]
    public function index(): Response
    {
        // Получаем всех артистов из базы данных
        $artistes = $this->artistRepo->findAll();

        return $this->render('accueil/index.html.twig', [
            'artistes' => $artistes
        ]);
    }
    #[Route('/accueil/search/{name}', name: 'app_accueil_search')]
    public function searchByName(string $name): Response
    {
        $artistes = $this->artistRepo->getSomeArtists($name);

        return $this->render('accueil/index.html.twig', [
        'artistes' => $artistes,
        'search_name' => $name
    ]);
    }
    #[Route('/accueil/querybuilder/{name}', name: 'app_accueil_querybuilder')]
public function searchWithQueryBuilder(string $name): Response
{
    $artistes = $this->artistRepo->getSomeArtistsWithQueryBuilder($name);

    return $this->render('accueil/index.html.twig', [
        'artistes' => $artistes,
        'search_name' => $name
    ]);
}

}