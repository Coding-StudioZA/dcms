<?php

namespace App\Controller;

use App\Entity\Faktury;
use App\Entity\Firmy;
use App\Form\Lista;
use App\Service\MyService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class MyController extends Controller
{
    /**
     * @Route("/{id}", name="lista_faktur")
     */
    public function invoicesList($id = null, MyService $myService, Request $request)
    {
        if ($id) {

            $dbresponse = $this->getDoctrine()->getRepository(Faktury::class)->find($id);

            $form = $this->createForm(Lista::class, $dbresponse);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $task = $form->getData();

                // Znajdź sposób aby wrzucić to w repozytorium, potem.
                $em = $this->getDoctrine()->getManager();
                $em->persist($task);
                $em->flush();

                return $this->redirectToRoute('lista_faktur');
            }

            return $this->render('views/edit.html.twig', [
                'form' => $form->createView(),
                ]);

        } else {

            $dbresponse = $this->getDoctrine()->getRepository(Faktury::class)->findAll();

            $dbresponse = $myService->formatStatesResponse($dbresponse);

            return $this->render('views/list.html.twig', [
                'faktury' => $dbresponse,
                ]);
        }
    }

    /**
     * @Route("/mail/{id}", name="compose_email")
     */
    public function createMail($id, MyService $myservice, Request $request, \Swift_Mailer $mailer, LoggerInterface $logger)
    {
        $doc = $this->getDoctrine();
        $invoices = $doc->getRepository(Faktury::class)->unpaidInvoices($id);
        $client = $doc->getRepository(Firmy::class)->findOneBy(['nr_kontrahenta' => $id]);

        $invoices = $myservice->formatStatesResponse($invoices);

        $form = $this->createFormBuilder()
            ->add('notatki', HiddenType::class, ['data' => $id, 'disabled' => true])
            ->add('save', SubmitType::class, ['label' => 'Wyślij'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $message = (new \Swift_Message('Płać albo zgiń'))
                ->setFrom('kdWebDevelopment@kwb.pl')
                ->setTo($client->getEmail())
                ->setBody(
                    $this->renderView('/emails/paymentAdvice.html.twig', [
                        'faktury' => $invoices,
                        'form' => $form->createView(),
                        'link' => false,
                    ]),
                    'text/html'
                );

            $mailer->send($message);

            return $this->redirectToRoute('lista_faktur');

        } else {

            return $this->render('/emails/paymentAdvice.html.twig', [
                'faktury' => $invoices,
                'form' => $form->createView(),
                'link' => true,
            ]);
        }
    }
}
