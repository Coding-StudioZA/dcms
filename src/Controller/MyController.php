<?php

namespace App\Controller;

use App\Entity\Faktury;
use App\Entity\Firmy;
use App\Entity\Kontakty;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class MyController extends Controller
{
    /**
     * @Route("/", name="lista_faktur")
     */
    public function index()
    {
        $stany = ['Nie zapłacona', 'Windykowana', 'U Prawnika', 'Zapłacona', 'Sprawa Sporna'];

        $dbResponse = $this->getDoctrine()->getManager()->getRepository(Faktury::class)->findAll();

        foreach($dbResponse as $format) {
            $format->setStan($stany[$format->getStan()]);
        }
        
        $debug = "dobrze";

        return $this->render('views/lista.html.twig', [ 'lista' => $dbResponse, 'debug' => $debug ]);
    }

}
