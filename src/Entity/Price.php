<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity()
 * @ORM\Table(name="prices",
 * uniqueConstraints={@ORM\UniqueConstraint(name="prices_type_place_unique", columns={"type", "place_id"})}
* )
 */
class Price
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"place", "price"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Choice(choices={"less_than_12", "for_all"})
     * @Assert\NotBlank()
     * @Groups({"place", "price"})
     */
    private $type;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank()
     * @Assert\Type("numeric")
     * @Assert\GreaterThanOrEqual(
     * value=0
     * )
     * @Groups({"place", "price"})
     */
    private $value;  

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Place", inversedBy="prices")
     * @Groups("price")
     */
    private $place;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getValue(): ?float
    {
        return $this->value;
    }

    public function setValue(float $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getPlace(): ?Place
    {
        return $this->place;
    }

    public function setPlace(?Place $place): self
    {
        $this->place = $place;

        return $this;
    }
}
