<?php

namespace App\Entity;

use App\Repository\ClientsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientsRepository::class)]
class Clients
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nameFirst = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nameLast = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $phone = null;

    #[ORM\Column]
    private ?bool $agreementGdpr = null;

    #[ORM\Column]
    private ?bool $agreementMarketing = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameFirst(): ?string
    {
        return $this->nameFirst;
    }

    public function setNameFirst(?string $nameFirst): self
    {
        $this->nameFirst = $nameFirst;

        return $this;
    }

    public function getNameLast(): ?string
    {
        return $this->nameLast;
    }

    public function setNameLast(?string $nameLast): self
    {
        $this->nameLast = $nameLast;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function isAgreementGdpr(): ?bool
    {
        return $this->agreementGdpr;
    }

    public function setAgreementGdpr(bool $agreementGdpr): self
    {
        $this->agreementGdpr = $agreementGdpr;

        return $this;
    }

    public function isAgreementMarketing(): ?bool
    {
        return $this->agreementMarketing;
    }

    public function setAgreementMarketing(bool $agreementMarketing): self
    {
        $this->agreementMarketing = $agreementMarketing;

        return $this;
    }
}
