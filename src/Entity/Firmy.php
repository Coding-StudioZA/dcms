<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FirmyRepository")
 */
class Firmy
{
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
     * @ORM\Column(type="integer", unique=true)
     */
    private $nr_kontrahenta;

}
