<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 *
 * @ORM\Table(name="product")
 * @ORM\Entity
 */
class Product
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="reducPrice", type="integer", nullable=false)
     */
    private $reducprice;

    /**
     * @var int|null
     *
     * @ORM\Column(name="realPrice", type="integer", nullable=true, options={"default"="NULL"})
     */
    private $realprice;

    /**
     * @var int|null
     *
     * @ORM\Column(name="stock", type="integer", nullable=true, options={"default"="NULL"})
     */
    private $stock;

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

    public function getReducprice(): ?int
    {
        return $this->reducprice;
    }

    public function setReducprice(int $reducprice): self
    {
        $this->reducprice = $reducprice;

        return $this;
    }

    public function getRealprice(): ?int
    {
        return $this->realprice;
    }

    public function setRealprice(?int $realprice): self
    {
        $this->realprice = $realprice;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(?int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }


}
