<?php

namespace App\Controller;

use App\Entity\EmailTemplates;
use App\Entity\InvociesImport;
use App\Entity\Invoices;
use App\Entity\Companies;
use App\Form\FormInvoice;
use App\Form\FormCompany;
use App\Form\InvoicesUpload;
use App\Service\MyService;
use App\Service\FileUploader;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Cache\Simple\FilesystemCache;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class MyController extends Controller
{
    /**
     * @Route("/{id}", name="invoices_list", requirements={"id"="\d+"})
     */
    public function invoicesList($id = null, MyService $myService, Request $request)
    {
        $session = new Session();

        if ($id) {

            $dbresponse = $this->getDoctrine()->getRepository(Invoices::class)->find($id);

            $form = $this->createForm(FormInvoice::class, $dbresponse);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $task = $form->getData();

                $myService->saveToDatabase($task);

                $session->getFlashBag()->add("notice", "Zmiany w ".$task->getInvoiceNumber()." zapisane!");

                return $this->redirectToRoute('invoices_list');
            }

            return $this->render('views/editForm.html.twig', [
                'form' => $form->createView(),
                'title' => 'Edytuj',
                ]);

        } else {

            $dbresponse = $this->getDoctrine()->getRepository(Invoices::class)->findAll();

            $return = $myService->formatInvoicesResponse($dbresponse);

            return $this->render('views/listInvoices.html.twig', [
                'invoices' => $return[0],
                'extradata' => $return[1],
                ]);
        }
    }

    /**
     * @Route("/companies/{id}", name="companies_list")
     */
    public function editEntry($id = null, MyService $myService, Request $request)
    {
        $session = new Session();

        if ($id) {

            $dbresponse = $this->getDoctrine()->getRepository(Companies::class)->find($id);

            $form = $this->createForm(FormCompany::class, $dbresponse);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $task = $form->getData();

                $myService->saveToDatabase($task);

                $session->getFlashBag()->add("notice", "Zmiany w ".$task->getCompanyName()." zapisane!");

                return $this->redirectToRoute('companies_list');
            }

            return $this->render('views/editForm.html.twig', [
                'form' => $form->createView(),
                'title' => 'Edytuj firmę'
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
    public function createMail($id, MyService $myService, Request $request, \Swift_Mailer $mailer)
    {
        $invoices = $this->getDoctrine()->getRepository(Invoices::class)->unpaidInvoices($id);
        $client = $this->getDoctrine()->getRepository(Companies::class)->findOneBy(['contractor_number' => $id]);
        $template = $this->getDoctrine()->getRepository(EmailTemplates::class)->findAll();
        $templates = [];
        $session = new Session();

        $invoices = ($myService->formatInvoicesResponse($invoices))[0];

        foreach ($template as $tmpl) {
            $templates[$tmpl->getId()] = $tmpl->getTitle();
        }

        if(isset($_GET["tmpl"])){
            $template = $templates[$_GET["tmpl"]];
        } else {
            $template = $templates[1];
        }

        $form = $this->createFormBuilder()
            ->add('notatki', HiddenType::class, ['data' => $id, 'disabled' => true])
            ->add('save', SubmitType::class, ['label' => 'Wyślij'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($client->getEmail() !== null) {
                $message = (new \Swift_Message('Płać albo zgiń'))
                    ->setFrom('kdWebDevelopment@kwb.pl')
                    ->setTo($client->getEmail())
                    ->setBody(
                        $this->renderView('/emails/'.$template.'.html.twig', [
                            'invoices' => $invoices,
                            'form' => $form->createView(),
                            'link' => false,
                        ]),
                        'text/html'
                    );

                $mailer->send($message);

                $session->getFlashBag()->add("notice", "Mail do " . $client->getCompanyName() . " wysłany!");

            } else {
                $session->getFlashBag()->add("notice", "Brak adresu e-mail do ". $client->getCompanyName());
            }

            return $this->redirectToRoute('invoices_list');

        } else {

            return $this->render('/emails/'.$template.'.html.twig', [
                'invoices' => $invoices,
                'form' => $form->createView(),
                'link' => true,
            ]);
        }
    }

    /**
     * @Route("/import", name="import_invoices")
     */
    public function import(Request $request, MyService $myService, LoggerInterface $logger)
    {
        $import = new InvociesImport();

        $form = $this->createForm(InvoicesUpload::class, $import);

        $form -> handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $file = $import->getAging();

            $uploader = new FileUploader($this->getParameter('imports_dir'));

            $import->setAging($uploader->upload($file));
            $import->setImportTime(new \DateTime('now'));

            $filePath = $this->getParameter('imports_dir')."/".$import->getAging();
            $spreadsheet = $myService->spreadsheetToArray($filePath);

            if ($myService->importAging($spreadsheet) == 0) {
                $fs = new Filesystem();
                $fs->remove($filePath);
            } else {
                $myService->saveToDatabase($import);
            }

            return $this->redirectToRoute('invoices_list');
        }

        return $this->render('views/editForm.html.twig', [
            'form' => $form->createView(),
            'title' => 'Importuj',
        ]);
    }

    /**
     * @Route("/test")
     */
    public function test(MyService $myService, LoggerInterface $logger, ValidatorInterface $validator){

        return $this->render("base.html.twig");
    }
}
