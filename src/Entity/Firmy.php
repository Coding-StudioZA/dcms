<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FirmyRepository")
 */
class Firmy
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
    private $nazwa;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $imie;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $nazwisko;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $telefon;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $komorka;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="integer")
     */
    private $nr_kontrahenta;

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
    public function getNazwa()
    {
        return $this->nazwa;
    }

    /**
     * @param mixed $nazwa
     */
    public function setNazwa($nazwa): void
    {
        $this->nazwa = $nazwa;
    }

    /**
     * @return mixed
     */
    public function getImie()
    {
        return $this->imie;
    }

    /**
     * @param mixed $imie
     */
    public function setImie($imie): void
    {
        $this->imie = $imie;
    }

    /**
     * @return mixed
     */
    public function getNazwisko()
    {
        return $this->nazwisko;
    }

    /**
     * @param mixed $nazwisko
     */
    public function setNazwisko($nazwisko): void
    {
        $this->nazwisko = $nazwisko;
    }

    /**
     * @return mixed
     */
    public function getTelefon()
    {
        return $this->telefon;
    }

    /**
     * @param mixed $telefon
     */
    public function setTelefon($telefon): void
    {
        $this->telefon = $telefon;
    }

    /**
     * @return mixed
     */
    public function getKomorka()
    {
        return $this->komorka;
    }

    /**
     * @param mixed $komorka
     */
    public function setKomorka($komorka): void
    {
        $this->komorka = $komorka;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
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
