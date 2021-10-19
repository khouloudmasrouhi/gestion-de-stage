<?php

namespace App\Controller;
use App\Entity\Stage;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AttestationController extends AbstractController
{
    #[Route('/attestation/{id}', name: 'attestation', methods: ['GET'])]
    public function index(Stage $stage): Response
    {

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('generation.html.twig', [
            'user' => $stage->getUtilisateur(),
            'stage' => $stage
        ]);
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();

        $pdfOptions->set('isHtml5ParserEnabled', true);
        $pdfOptions->set('fontHeighRati', 1);
        $pdfOptions->set('isRemoteEnabled', true);
        $pdfOptions->set('debugKeepTemp', true);
        $pdfOptions->set('defaultFont', 'Arial');


        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);


        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (inline view)
        $dompdf->stream("attestation.pdf", [
            "Attachment" => false
        ]);
        return new Response('', 200, [
            'Content-Type' => 'application/pdf',
        ]);
    }
}
