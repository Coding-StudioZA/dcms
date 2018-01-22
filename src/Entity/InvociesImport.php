<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InvociesImportRepository")
 */
class InvociesImport
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank(message="Please choose some file.")
     * @Assert\File(mimeTypes= { "application/vnd.ms-excel" })
     */
    private $aging;

    /**
     * @ORM\Column(type="datetime")
     */
    private $import_time;

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
    public function getAging()
    {
        return $this->aging;
    }

    /**
     * @param mixed $aging
     */
    public function setAging($aging): void
    {
        $this->aging = $aging;
    }

    /**
     * @return mixed
     */
    public function getImportTime()
    {
        return $this->import_time;
    }

    /**
     * @param mixed $import_time
     */
    public function setImportTime($import_time): void
    {
        $this->import_time = $import_time;
    }


}
