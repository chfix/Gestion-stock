<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
#[ApiResource(
    collectionOperations: ['get' => ['normalization_context' => ['groups' => 'order:list']]],
    itemOperations: ['get' => ['normalization_context' => ['groups' => 'order:item']]],
    paginationEnabled: false,
)]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\OneToOne(inversedBy: 'orders', targetEntity: Product::class, cascade:["persist","remove"])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['order:list', 'order:item'])]
    private $Product;

    #[ORM\Column(type: 'float')]
    #[Groups(['order:list', 'order:item'])]
    private $unity_price;

    #[ORM\Column(type: 'float')]
    #[Groups(['order:list', 'order:item'])]
    private $total_price;

    #[ORM\Column(type: 'integer')]
    #[Groups(['order:list', 'order:item'])]
    private $quantity;

    #[ORM\Column(type: 'datetime_immutable')]
    #[Groups(['order:list', 'order:item'])]
    private $createdAt;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private $updatedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): ?Product
    {
        return $this->Product;
    }

    public function setProduct(Product $Product): self
    {
        $this->Product = $Product;

        return $this;
    }

    public function getUnityPrice(): ?float
    {
        return $this->unity_price;
    }

    public function setUnityPrice(float $unity_price): self
    {
        $this->unity_price = $unity_price;

        return $this;
    }

    public function getTotalPrice(): ?float
    {
        return $this->total_price;
    }

    public function setTotalPrice(float $total_price): self
    {
        $this->total_price = $total_price;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
