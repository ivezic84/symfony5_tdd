<?php

namespace App\Entity;

use App\Repository\StockRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StockRepository::class)
 */
class Stock
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $symbol;

    /**
     * @ORM\Column(type="string")
     */
    private $exchangeName;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $shortName;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $quoteType;


    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getSymbol()
    {
        return $this->symbol;
    }

    /**
     * @param mixed $symbol
     */
    public function setSymbol($symbol): void
    {
        $this->symbol = $symbol;
    }

    /**
     * @return mixed
     */
    public function getExchangeName()
    {
        return $this->exchangeName;
    }

    /**
     * @param mixed $exchangeName
     */
    public function setExchangeName($exchangeName): void
    {
        $this->exchangeName = $exchangeName;
    }

    /**
     * @return mixed
     */
    public function getShortName()
    {
        return $this->shortName;
    }

    /**
     * @param mixed $shortName
     */
    public function setShortName($shortName): void
    {
        $this->shortName = $shortName;
    }

    /**
     * @return mixed
     */
    public function getQuoteType()
    {
        return $this->quoteType;
    }

    /**
     * @param mixed $quoteType
     */
    public function setQuoteType($quoteType): void
    {
        $this->quoteType = $quoteType;
    }

}
