<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InvoicesRepository")
 */
class Invoices
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $evidence_number;

    /**
     * @ORM\Column(type="string")
     */
    private $invoice_number;

    /**
     * @ORM\Column(type="date")
     */
    private $due_date;

    /**
     * @ORM\Column(type="smallint", options={"default": 0})
     */
    private $due_interval = 0;

    /**
     * @ORM\Column(type="float")
     */
    private $amount;

    /**
     * @ORM\Column(type="smallint", options={"default": 0})
     * @Assert\Range(min = 0, max = 4, minMessage = "Unknown range.", maxMessage = "Unknown range.")
     */
    private $state = 0;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $notes;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Companies", inversedBy="invoices", fetch="EAGER")
     * @ORM\JoinColumn(nullable=true)
     */
    private $contractor;

    /**
     * @return mixed
     */
    public function getContractor()
    {
        return $this->contractor;
    }

    /**
     * @param mixed $contractor
     */
    public function setContractor($contractor): void
    {
        $this->contractor = $contractor;
    }

    /**
     * @return mixed
     */
    public function getDueInterval()
    {
        return $this->due_interval;
    }

    /**
     * @param mixed $due_interval
     */
    public function setDueInterval($due_interval): void
    {
        $this->due_interval = $due_interval;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getEvidenceNumber()
    {
        return $this->evidence_number;
    }

    /**
     * @param mixed $evidence_number
     */
    public function setEvidenceNumber($evidence_number): void
    {
        $this->evidence_number = $evidence_number;
    }

    /**
     * @return mixed
     */
    public function getInvoiceNumber()
    {
        return $this->invoice_number;
    }

    /**
     * @param mixed $invoice_number
     */
    public function setInvoiceNumber($invoice_number): void
    {
        $this->invoice_number = $invoice_number;
    }

    /**
     * @return mixed
     */
    public function getDueDate()
    {
        return $this->due_date;
    }

    /**
     * @param mixed $due_date
     */
    public function setDueDate($due_date): void
    {
        $this->due_date = $due_date;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param mixed $state
     */
    public function setState($state): void
    {
        $this->state = $state;
    }

    /**
     * @return mixed
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * @param mixed $notes
     */
    public function setNotes($notes): void
    {
        $this->notes = $notes;
    }

}
