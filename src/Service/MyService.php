<?php

namespace App\Service;

use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Entity\Invoices;
use App\Entity\Companies;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Symfony\Component\HttpFoundation\Session\Session;
use Psr\Log\LoggerInterface;

class MyService
{
    private $db;
    private $logger;
    private $dbm;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function setUp($db)
    {
        $this->db = $db;
        $this->dbm = $db->getManager();
    }

    public function formatInvoicesResponse($dbresponse)
    {
        $extradata = [];
        $stany = ['Niezapłacona', 'Windykowana', 'U Prawnika', 'Zapłacona', 'Sprawa sporna'];

        foreach ($dbresponse as $format) {
            $format->setState($stany[$format->getState()]);
            $extradata['pastdue'][$format->getEvidenceNumber()] = date_diff($format->getDueDate(), new \DateTime("now"))->format("%a");
        }

        $this->logger->critical("oj", ["ok" =>$dbresponse]);

        return [$dbresponse, $extradata];
    }

    public function spreadsheetToArray($filePath)
    {
        $inputFileType = IOFactory::identify($filePath);
        $reader = IOFactory::createReader($inputFileType);
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($filePath);
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null,false,false,true);

        $new = \PhpOffice\PhpSpreadsheet\Calculation\Functions::RETURNDATE_PHP_OBJECT;

        return $sheetData;
    }

    public function saveToDatabase($dbObject)
    {
        $this->dbm->persist($dbObject);
        $this->dbm->flush();

        return true;
    }

    public function importAging($spreadsheet)
    {
        $companies = $this->db->getRepository(Companies::class);
        $invoices = $this->db->getRepository(Invoices::class);
        $session = new Session();
        $addedInvoices = 0;
        $addedCompanies = 0;
        $companiesTemp = [];
        $companiesTempOuter = [];
        $invoicesTemp = [];
        $companiesObj = [];
        $batchSize = 500;

        $companiesdb = $companies->findAll();

        foreach ($companiesdb as $value) {
            $companiesTempOuter[] = $value->getContractorNumber();
        }

        $this->logger->critical("debuk", ["comapniesObj" => $companiesObj, "companiesOuter" => $companiesTempOuter]);

        foreach ($spreadsheet as $key => $value) {

            if ($key != 1) {

                if (in_array($value["A"], $companiesTempOuter) == false && in_array($value["A"], $companiesTemp) == false) {

                    $company = new Companies();
                    $company->setCompanyName($value["B"]);
                    $company->setContractorNumber($value["A"]);
                    $this->dbm->persist($company);

                    $addedCompanies++;

                    if (($addedCompanies % $batchSize) === 0) {
                        $this->dbm->flush();
                        $this->dbm->clear();
                    }
                }

                $companiesTemp[] = $value["A"];
            }
        }

        $this->dbm->flush();

        $companiesdb = $companies->findAll();
        $invoicesdb = $invoices->findAll();

        foreach ($companiesdb as $value) {
            $companiesObj[$value->getContractorNumber()] = $value;
        }

        foreach ($invoicesdb as $value){
            $invoicesTemp[] = $value->getEvidenceNumber();
        }

        foreach ($spreadsheet as $key => $value) {

            if ($key != 1 && in_array($value["D"], $invoicesTemp) == false) {

                $dateTime = Date::excelToDateTimeObject($spreadsheet[$key]["C"], new \DateTimeZone("Europe/Warsaw"));
                $invoice = new Invoices();
                $invoice->setContractor($companiesObj[$value["A"]]);
                $invoice->setDueDate($dateTime);
                $invoice->setEvidenceNumber($value["D"]);
                $invoice->setInvoiceNumber($value["E"]);
                $invoice->setAmount($value["O"]);
                $this->dbm->persist($invoice);

                $addedInvoices++;

                if (($addedInvoices % $batchSize) === 0) {
                    $this->dbm->flush();
                    $this->dbm->clear();
                }

            }
        }
//        Flushuje mi zapisanie nazwy pliku excelowskiego do bazy.
//        $this->dbm->flush();


        $session->getFlashBag()->add("notice", "Dodano ".$addedInvoices." faktur oraz ".$addedCompanies." firm!");

        return $addedInvoices+$addedCompanies;
    }

}