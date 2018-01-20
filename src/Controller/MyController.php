<?php

namespace App\Controller;

use App\Entity\Invoices;
use App\Entity\Companies;
use App\Form\FormInvoice;
use App\Form\FormCompany;
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
     * @Route("/{id}", name="invoices_list", requirements={"id"="\d+"})
     */
    public function invoicesList($id = null, MyService $myService, Request $request)
    {
        if ($id) {

            $dbresponse = $this->getDoctrine()->getRepository(Invoices::class)->find($id);

            $form = $this->createForm(FormInvoice::class, $dbresponse);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $task = $form->getData();

                // Znajdź sposób aby wrzucić to w repozytorium, potem.
                $em = $this->getDoctrine()->getManager();
                $em->persist($task);
                $em->flush();

                return $this->redirectToRoute('invoices_list');
            }

            return $this->render('views/editForm.html.twig', [
                'form' => $form->createView(),
                ]);

        } else {

            $dbresponse = $this->getDoctrine()->getRepository(Invoices::class)->findAll();

            $dbresponse = $myService->formatStatesResponse($dbresponse);

            return $this->render('views/listInvoices.html.twig', [
                'invoices' => $dbresponse,
                ]);
        }
    }

    /**
     * @Route("/companies/{id}", name="companies_list")
     */
    public function editEntry($id = null, Request $request){
        if ($id) {

            $dbresponse = $this->getDoctrine()->getRepository(Companies::class)->find($id);

            $form = $this->createForm(FormCompany::class, $dbresponse);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $task = $form->getData();

                // Znajdź sposób aby wrzucić to w repozytorium, potem.
                $em = $this->getDoctrine()->getManager();
                $em->persist($task);
                $em->flush();

                return $this->redirectToRoute('companies_list');
            }

            return $this->render('views/editForm.html.twig', [
                'form' => $form->createView(),
            ]);

        } else {

            $dbresponse = $this->getDoctrine()->getRepository(Companies::class)->findAll();

            return $this->render('views/listCompanies.html.twig', [
                'contractors' => $dbresponse,
            ]);
        }

    }

    /**
     * @Route("/mail/{id}", name="compose_email")
     */
    public function createMail($id, MyService $myservice, Request $request, \Swift_Mailer $mailer, LoggerInterface $logger)
    {
        $doc = $this->getDoctrine();
        $invoices = $doc->getRepository(Invoices::class)->unpaidInvoices($id);
        $client = $doc->getRepository(Companies::class)->findOneBy(['contractor_number' => $id]);

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

            return $this->redirectToRoute('invoices_list');

        } else {

            return $this->render('/emails/paymentAdvice.html.twig', [
                'invoices' => $invoices,
                'form' => $form->createView(),
                'link' => true,
            ]);
        }
    }

    /**
     * @Route("/import", name="import_invoices")
     */
    public function import()
    {
        return new Response("blablablablack");
    }
}
