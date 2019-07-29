<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderRepository")
 */
class Orders
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $product;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $payment_method;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Address",cascade={"persist"})
     */
    private $addresses_billing;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Address",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $addresses_shipping;

     /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $orderapi;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): ?string
    {
        return $this->product;
    }

    public function setProduct(?string $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getPaymentMethod(): ?string
    {
        return $this->payment_method;
    }

    public function setPaymentMethod(string $payment_method): self
    {
        $this->payment_method = $payment_method;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getAddressesBilling(): ?Address
    {
        return $this->addresses_billing;
    }

    public function setAddressesBilling(?Address $addresses_billing): self
    {
        $this->addresses_billing = $addresses_billing;

        return $this;
    }

    public function getAddressesShipping(): ?Address
    {
        return $this->addresses_shipping;
    }

    public function setAddressesShipping(?Address $addresses_shipping): self
    {
        $this->addresses_shipping = $addresses_shipping;

        return $this;
    }

    public function getOrderapi() :?string
    {
        return $this->orderapi;
    }

    public function setOrderapi(string $orderapi):self
    {
        $this->orderapi = $orderapi;

        return $this;
    }
}
