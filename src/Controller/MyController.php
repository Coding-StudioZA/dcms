<?php

namespace App\Controller;

use App\Entity\Faktury;
use App\Entity\Firmy;
use App\Entity\Kontakty;
use App\Form\Lista;
use App\Service\MyService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class MyController extends Controller
{
    /**
     * @Route("/{id}", name="lista_faktur")
     */
    public function listaFaktur($id = null, MyService $myService, Request $request)
    {
        if($id){

            $dbResponse = $this->getDoctrine()->getRepository(Faktury::class)->find($id);

            $form = $this->createForm(Lista::class, $dbResponse);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $task = $form->getData();

                $em = $this->getDoctrine()->getManager();
                $em->persist($task);
                $em->flush();

                return $this->redirectToRoute('lista_faktur');
            }

            return $this->render('views/edit.html.twig', [ 'form' => $form->createView() ]);

        }
        else {

            $dbResponse = $this->getDoctrine()->getRepository(Faktury::class)->findAll();

            $dbResponse = $myService->formatStatesResponse($dbResponse);

            return $this->render('views/list.html.twig', ['faktury' => $dbResponse]);
        }
    }

}
