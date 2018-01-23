<?php

namespace App\Service;

use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Entity\Invoices;
use App\Entity\Companies;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Symfony\Component\HttpFoundation\Session\Session;

class MyService
{
    private $db;
    private $logger;
    private $dbm;

    public function setUp($db, $logger = null)
    {
        $this->db = $db;
        $this->logger = $logger;
        $this->dbm = $db->getManager();
    }

    private function getStateArray()
    {
        return ['Niezapłacona', 'Windykowana', 'U Prawnika', 'Zapłacona', 'Sprawa sporna'];
    }

    public function formatStatesResponse($dbResponse)
    {
        $stany = $this->getStateArray();
        foreach ($dbResponse as $format) {
            $format->setState($stany[$format->getState()]);
        }

        return $dbResponse;
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
        // Odczuwam tutaj wydajnościowy swąd... 2 zapytania do bazy dla przetwożenia JEDNEGO rekordu? WTF that shiet ugly Ok ale potem

        $companies = $this->db->getRepository(Companies::class);
        $invoices = $this->db->getRepository(Invoices::class);
        $today = new \DateTime("now");
        $session = new Session();
        $addedInvoices = 0;
        $addedCompanies = 0;

        foreach ($spreadsheet as $key => $value) {
            if ($key != 1) {
                if ($invoices->findBy(["evidence_number" => $value["D"]]) == []) {
                    $dateTime = Date::excelToDateTimeObject($spreadsheet[$key]["C"], new \DateTimeZone("Europe/Warsaw"));
                    $invoice = new Invoices();
                    $invoice->setContractorNumber($value["A"]);
                    $invoice->setDueDate($dateTime);
                    $invoice->setEvidenceNumber($value["D"]);
                    $invoice->setInvoiceNumber($value["E"]);
                    $invoice->setAmount($value["O"]);
                    $invoice->setDueInterval(date_diff($dateTime, $today)->format("%a"));
                    $this->dbm->persist($invoice);
                    $addedInvoices++;
                }
            }
        }
        $this->dbm->flush();

        foreach ($spreadsheet as $key => $value) {
            if ($key != 1) {
                if ($companies->findBy(["contractor_number" => $value["A"]]) == []) {
                    $company = new Companies();
                    $company->setCompanyName($value["B"]);
                    $company->setContractorNumber($value["A"]);
                    $this->dbm->persist($company);
                    $addedCompanies++;
                }
            }
        }
        $this->dbm->flush();

        $session->getFlashBag()->add("notice", "Dodano ".$addedInvoices." faktur oraz ".$addedCompanies." firm!");

        return $addedInvoices+$addedCompanies;
    }

}