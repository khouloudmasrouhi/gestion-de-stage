<?php

namespace App\Controller;

use App\Entity\DemandeStage;
use App\Entity\Stage;
use App\Entity\Utilisateur;
use App\Form\DemandeStageType;
use App\Form\StageType;
use App\Repository\DemandeStageRepository;
use App\Repository\OffreStageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/demande')]
class DemandeStageController extends AbstractController
{
    #[Route('/new', name: 'demandestage', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $demandeStage = new DemandeStage();
        $form = $this->createForm(DemandeStageType::class, $demandeStage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($demandeStage);
            $entityManager->flush();
            $this->addFlash('success', 'Demande de stage envoyer avec succès' );


            return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('demande_stage/new.html.twig', [
            'demandeStage' => $demandeStage,
            'demandeForm' => $form,
        ]);


    }

    #[Route('/{id}/edit', name: 'satge_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Stage $stage): Response
    {
        $form = $this->createForm(StageType::class, $stage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'stage modifié avec succès' );
            return $this->redirectToRoute('demande_stage', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('demande_stage/edit.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/accepter/{id}', name: 'demandestage_stage', methods: ['GET', 'POST'] )]

    public function accepter(DemandeStage $demande, UserPasswordHasherInterface $passwordEncoder) : Response
    {

        $existuser = $this->getDoctrine()
            ->getRepository(Utilisateur::class)
            ->findOneBy(['email' => $demande->getEmail()]);

        if (!$existuser)
        {
            $user = new Utilisateur();
            $user ->setNom($demande->getNom());
            $user ->setPrenom($demande->getPrenom());
            $user ->setEmail($demande->getEmail());
            $user ->setCin($demande->getCin());
            $user ->setLogin($demande->getNom());
            $user ->setTelephone($demande->getTelephone());
            $user->setPassword(
                $passwordEncoder->hashPassword($user, $demande->getEmail())
            );
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('success', 'Inscription réussie ');
        }


        if ($demande->getStage() == null)
        {
            $stage = new Stage();
            $stage ->setDateDebut(($demande->getOffrestage())->getDateDebut());
            $stage ->setDateFin(($demande->getOffrestage())->getDateFin());
            if ($existuser){
                $stage ->setUtilisateur($existuser);
            }
            else{
                $stage ->setUtilisateur($user);

            }
            $demande->setStage($stage);
            $entity = $this->getDoctrine()->getManager();
            $entityDemande = $this->getDoctrine()->getManager();
            $entity->persist($stage);
            $entityDemande->persist($demande);
            $entity->flush();
            $entityDemande->flush();
            $this->addFlash('success', 'Creation Stage!!! ');
        }
        else{
            $existuser->setCin($demande->getCin());
        }


        return $this->render('demande_stage/show.html.twig');
    }



    #[Route('/{id}', name: 'demandestage_show', methods: ['GET'])]
    public function show(DemandeStage $demandeStage): Response
    {
        return $this->render('demande_stage/show.html.twig', [
            'demande_stage' => $demandeStage,
        ]);
    }

    /**
     * @param OffreStageRepository $offreStageRepository
     * @return Response
     */

    #[Route('stage/list', name: 'demande_stage', methods: ['GET'])]
    public function index(DemandeStageRepository $demandeStageRepository): Response
    {
        return $this->render('demande_stage/index.html.twig', [
            'demande_stages' => $demandeStageRepository->findAll(),
        ]);
    }




}
