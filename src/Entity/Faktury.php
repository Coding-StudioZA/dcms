<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FakturyRepository")
 */
class Faktury
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
    private $nr_ewidencyjny;

    /**
     * @ORM\Column(type="string")
     */
    private $nr_dokumentu;

    /**
     * @ORM\Column(type="date")
     */
    private $termin_zaplaty;

    /**
     * @ORM\Column(type="float")
     */
    private $kwota;

    /**
     * @ORM\Column(type="smallint")
     */
    private $stan;

    /**
     * @ORM\Column(type="integer")
     */
    private $nr_kontrahenta;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $notatki;

    /**
     * @return mixed
     */
    public function getNotatki()
    {
        return $this->notatki;
    }

    /**
     * @param mixed $notatki
     */
    public function setNotatki($notatki): void
    {
        $this->notatki = $notatki;
    }

    /**
     * @return mixed
     */
    public function getNrEwidencyjny()
    {
        return $this->nr_ewidencyjny;
    }

    /**
     * @param mixed $nr_ewidencyjny
     */
    public function setNrEwidencyjny($nr_ewidencyjny): void
    {
        $this->nr_ewidencyjny = $nr_ewidencyjny;
    }

    /**
     * @return mixed
     */
    public function getNrDokumentu()
    {
        return $this->nr_dokumentu;
    }

    /**
     * @param mixed $nr_dokumentu
     */
    public function setNrDokumentu($nr_dokumentu): void
    {
        $this->nr_dokumentu = $nr_dokumentu;
    }

    /**
     * @return mixed
     */
    public function getTerminZaplaty()
    {
        return $this->termin_zaplaty;
    }

    /**
     * @param mixed $termin_zaplaty
     */
    public function setTerminZaplaty($termin_zaplaty): void
    {
        $this->termin_zaplaty = $termin_zaplaty;
    }

    /**
     * @return mixed
     */
    public function getKwota()
    {
        return $this->kwota;
    }

    /**
     * @param mixed $kwota
     */
    public function setKwota($kwota): void
    {
        $this->kwota = $kwota;
    }

    /**
     * @return mixed
     */
    public function getStan()
    {
        return $this->stan;
    }

    /**
     * @param mixed $stan
     */
    public function setStan($stan): void
    {
        $this->stan = $stan;
    }

    /**
     * @return mixed
     */
    public function getNrKontrahenta()
    {
        return $this->nr_kontrahenta;
    }

    /**
     * @param mixed $nr_kontrahenta
     */
    public function setNrKontrahenta($nr_kontrahenta): void
    {
        $this->nr_kontrahenta = $nr_kontrahenta;
    }


}
