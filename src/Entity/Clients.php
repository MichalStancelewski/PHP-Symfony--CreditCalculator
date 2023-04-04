<?php

namespace App\Entity;

use App\Repository\ClientsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ClientsRepository::class)]
class Clients implements EnquiryInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups("client")]
    #[Assert\NotBlank]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nameFirst = null;

    #[Groups("client")]
    #[Assert\NotBlank]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nameLast = null;

    #[Groups("client")]
    #[Assert\NotBlank]
    #[Assert\Email]
    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[Groups("client")]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $phone = null;

    #[Groups("client")]
    #[ORM\Column]
    private ?bool $agreementGdpr = null;

    #[Groups("client")]
    #[ORM\Column]
    private ?bool $agreementMarketing = null;

    #[Groups("credit_data_details")]
    #[ORM\OneToMany(mappedBy: 'clients', targetEntity: CreditData::class)]
    private Collection $creditData;

    public function __construct()
    {
        $this->creditData = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, CreditData>
     */
    public function getCreditData(): Collection
    {
        return $this->creditData;
    }

    public function addCreditData(CreditData $creditData): self
    {
        if (!$this->creditData->contains($creditData)) {
            $this->creditData->add($creditData);
            $creditData->setClients($this);
        }

        return $this;
    }

    public function removeCreditData(CreditData $creditData): self
    {
        if ($this->creditData->removeElement($creditData)) {
            // set the owning side to null (unless already changed)
            if ($creditData->getClients() === $this) {
                $creditData->setClients(null);
            }
        }

        return $this;
    }
}
