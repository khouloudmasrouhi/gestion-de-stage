<?php


namespace App\Controller;



use App\Entity\OffreStage;
use App\Repository\OffreStageRepository;
use App\Repository\SpecialiteRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    /**
     * @var OffreStageRepository
     */
    private $repository;

    /**
     * @var ObjectManager
     */
    private  $em;

    public function __construct(OffreStageRepository $repository)//ObjectManager $em)
    {
        $this->repository = $repository;
        //$this->em = $em;
    }
    /**
     * @Route("/offres_stages/{slug}-{id}", name="offreStages.show", requirements={"slug": "[a-z0-9\-]*"})
     * @param OffreStage $offreStage
     * @return Response
     */
    public function show(OffreStage $offreStage, string $slug): Response
    {
        if($offreStage->getSlug() !== $slug){
            return $this->redirectToRoute('offreStages.show',[
                'id' => $offreStage->getId(),
                'slug' => $offreStage->getSlug()
            ], 301);
        }
        return $this->render('offreStages/show.html.twig' ,[
            'offreStages' => $offreStage,
            'current_menu' => 'offres'
        ]);
    }



    /**
     * @Route("/offres", name="offres")
     * @param OffreStageRepository $repository
     * @return string
     */
    public function index(OffreStageRepository $repository,SpecialiteRepository $specialRepo , Request $request )
    {
        // on definit le nombre d'element par page
        $limit = 6;
        // on récupère le numéro de page
        $page = (int)$request->query->get("page",1 );
        // on récupère les filtres
        $filters = $request->get("specialites");
        //on récupère les offres de la page en fonction de filtre
        $offreStages = $repository->getPaginatedOffreStage($page,$limit, $filters);
        // on récupère le nombre total d'offres
        $total = $repository->getTotalOffreStage($filters);

        // on vérifie si on a une requete ajax
        if ($request->get('ajax')){
            return new JsonResponse([
                'content' => $this->renderView('_content.html.twig', compact('offreStages','limit','page','total'))
            ]);
        }

        //On va chercher toutes les spécialités
        $specialites = $specialRepo->findAll();
        return $this->render('home.html.twig', compact('offreStages','limit','page','total'
            ,'specialites'));
    }

    /**
     * @Route("/admin", name="home")
     */
    public function routeAdmin()
    {
        return $this->render('adminrole.html.twig');
    }
    /**
     * @Route("/home", name="homePage")
     */
    public function home()
    {
        return $this->render('accueil.html.twig');
    }

}