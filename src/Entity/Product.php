<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\NumericFilter;
use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ApiResource(
 *     collectionOperations={"get"},
 *     attributes={
 *          "pagination_items_per_page"=10,
 *          "formats"={"json"}
 *     },
 *     cacheHeaders={"max_age"=300, "shared_max_age"=300, "vary"={"Authorization", "Accept-Language"}}
 * )
 * @ApiFilter(NumericFilter::class, properties={"weather"})
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(
     *     min=2,
     *     max=20
     * )
     */
    private $sku;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(
     *     min=10,
     *     max=255
     * )
     */
    private $name;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     * @Assert\NotBlank()
     */
    private $price;

    /**
     * @ORM\Column(type="smallint")
     * @Assert\Range(
     *     min=0,
     *     max=2
     * )
     */
    private $weather;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSku(): ?string
    {
        return $this->sku;
    }

    public function setSku(string $sku): self
    {
        $this->sku = $sku;

        return $this;
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

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getWeather(): ?int
    {
        return $this->weather;
    }

    public function setWeather(int $weather): self
    {
        $this->weather = $weather;

        return $this;
    }
}
