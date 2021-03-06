<?php

namespace App\Entity;

use App\Repository\PolicyThemeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PolicyThemeRepository::class)
 */
class PolicyTheme
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\OneToOne(targetEntity=Image::class, cascade={"persist", "remove"})
     */
    private $symbol;

    /**
     * @ORM\Column(type="text")
     */
    private $text;

    /**
     * @ORM\OneToMany(targetEntity=Policy::class, mappedBy="policyTheme")
     */
    private $policies;

    /**
     * @ORM\OneToMany(targetEntity=Institution::class, mappedBy="policyTheme")
     */
    private $institutions;

    public function __construct()
    {
        $this->policies = new ArrayCollection();
        $this->institutions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSymbol(): ?Image
    {
        return $this->symbol;
    }

    public function setSymbol(?Image $symbol): self
    {
        $this->symbol = $symbol;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return Collection|Policy[]
     */
    public function getPolicies(): Collection
    {
        return $this->policies;
    }

    public function addPolicy(Policy $policy): self
    {
        if (!$this->policies->contains($policy)) {
            $this->policies[] = $policy;
            $policy->setPolicyTheme($this);
        }

        return $this;
    }

    public function removePolicy(Policy $policy): self
    {
        if ($this->policies->contains($policy)) {
            $this->policies->removeElement($policy);
            // set the owning side to null (unless already changed)
            if ($policy->getPolicyTheme() === $this) {
                $policy->setPolicyTheme(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Institution[]
     */
    public function getInstitutions(): Collection
    {
        return $this->institutions;
    }

    public function addInstitution(Institution $institution): self
    {
        if (!$this->institutions->contains($institution)) {
            $this->institutions[] = $institution;
            $institution->setPolicyTheme($this);
        }

        return $this;
    }

    public function removeInstitution(Institution $institution): self
    {
        if ($this->institutions->contains($institution)) {
            $this->institutions->removeElement($institution);
            // set the owning side to null (unless already changed)
            if ($institution->getPolicyTheme() === $this) {
                $institution->setPolicyTheme(null);
            }
        }

        return $this;
    }
}
