<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BookRepository::class)
 */
class Book
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=Library::class, inversedBy="books")
     * @ORM\JoinColumn(nullable=false)
     */
    private $library;

    /**
     * @ORM\Column(type="boolean", options={"default":true})
     */
    private $isActive;

    /**
     * @ORM\OneToMany(targetEntity=Rent::class, mappedBy="book", orphanRemoval=true)
     */
    private $rents;

    /**
     * @ORM\ManyToOne(targetEntity=Orders::class, inversedBy="books")
     */
    private $orders;

    /**
     * @ORM\ManyToOne(targetEntity=Genere::class, inversedBy="books")
     */
    private $genere;

    /**
     * Book constructor.
     * @param $id
     * @param $name
     * @param $library
     */
    public function __construct($name, $library, $genere, $order)
    {
        $this->name = $name;
        $this->library = $library;
        $this->isActive = true;
        $this->orders = $order;
        $this->genere = $genere;
        $this->rents = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getLibrary(): ?Library
    {
        return $this->library;
    }

    public function setLibrary(?Library $library): self
    {
        $this->library = $library;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * @return Collection|Rent[]
     */
    public function getRents(): Collection
    {
        return $this->rents;
    }

    public function addRent(Rent $rent): self
    {
        if (!$this->rents->contains($rent)) {
            $this->rents[] = $rent;
            $rent->setBook($this);
        }

        return $this;
    }

    public function removeRent(Rent $rent): self
    {
        if ($this->rents->removeElement($rent)) {
            // set the owning side to null (unless already changed)
            if ($rent->getBook() === $this) {
                $rent->setBook(null);
            }
        }

        return $this;
    }

    public function getOrders(): ?Orders
    {
        return $this->orders;
    }

    public function setOrders(?Orders $orders): self
    {
        $this->orders = $orders;

        return $this;
    }

    public function getGenere(): ?Genere
    {
        return $this->genere;
    }

    public function setGenere(?Genere $genere): self
    {
        $this->genere = $genere;

        return $this;
    }
}
