<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TyrePallet
 *
 * @ORM\Table(name="tyre_pallet")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TyrePalletRepository")
 */
class TyrePallet
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="tyre", type="string", length=255)
     */
    private $tyre;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="standardLength", type="string", length=255)
     */
    private $standardLength;

    /**
     * @var string
     *
     * @ORM\Column(name="standardWidth", type="string", length=255)
     */
    private $standardWidth;

    /**
     * @var string
     *
     * @ORM\Column(name="standardQuantity", type="string", length=255)
     */
    private $standardQuantity;

    /**
     * @var string
     *
     * @ORM\Column(name="italyLength", type="string", length=255)
     */
    private $italyLength;

    /**
     * @var string
     *
     * @ORM\Column(name="italyWidth", type="string", length=255)
     */
    private $italyWidth;

    /**
     * @var string
     *
     * @ORM\Column(name="italyQuantity", type="string", length=255)
     */
    private $italyQuantity;

    /**
     * @var string
     *
     * @ORM\Column(name="usaLength", type="string", length=255)
     */
    private $usaLength;

    /**
     * @var string
     *
     * @ORM\Column(name="usaWidth", type="string", length=255)
     */
    private $usaWidth;

    /**
     * @var string
     *
     * @ORM\Column(name="usaQuantity", type="string", length=255)
     */
    private $usaQuantity;




    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set tyre
     *
     * @param string $tyre
     *
     * @return TyrePallet
     */
    public function setTyre($tyre)
    {
        $this->tyre = $tyre;

        return $this;
    }

    /**
     * Get tyre
     *
     * @return string
     */
    public function getTyre()
    {
        return $this->tyre;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return TyrePallet
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set standardLength
     *
     * @param string $standardLength
     *
     * @return TyrePallet
     */
    public function setStandardLength($standardLength)
    {
        $this->standardLength = $standardLength;

        return $this;
    }

    /**
     * Get standardLength
     *
     * @return string
     */
    public function getStandardLength()
    {
        return $this->standardLength;
    }

    /**
     * Set standardWidth
     *
     * @param string $standardWidth
     *
     * @return TyrePallet
     */
    public function setStandardWidth($standardWidth)
    {
        $this->standardWidth = $standardWidth;

        return $this;
    }

    /**
     * Get standardWidth
     *
     * @return string
     */
    public function getStandardWidth()
    {
        return $this->standardWidth;
    }

    /**
     * Set standardQuantity
     *
     * @param string $standardQuantity
     *
     * @return TyrePallet
     */
    public function setStandardQuantity($standardQuantity)
    {
        $this->standardQuantity = $standardQuantity;

        return $this;
    }

    /**
     * Get standardQuantity
     *
     * @return string
     */
    public function getStandardQuantity()
    {
        return $this->standardQuantity;
    }

    /**
     * Set italyLength
     *
     * @param string $italyLength
     *
     * @return TyrePallet
     */
    public function setItalyLength($italyLength)
    {
        $this->italyLength = $italyLength;

        return $this;
    }

    /**
     * Get italyLength
     *
     * @return string
     */
    public function getItalyLength()
    {
        return $this->italyLength;
    }

    /**
     * Set italyWidth
     *
     * @param string $italyWidth
     *
     * @return TyrePallet
     */
    public function setItalyWidth($italyWidth)
    {
        $this->italyWidth = $italyWidth;

        return $this;
    }

    /**
     * Get italyWidth
     *
     * @return string
     */
    public function getItalyWidth()
    {
        return $this->italyWidth;
    }

    /**
     * Set italyQuantity
     *
     * @param string $italyQuantity
     *
     * @return TyrePallet
     */
    public function setItalyQuantity($italyQuantity)
    {
        $this->italyQuantity = $italyQuantity;

        return $this;
    }

    /**
     * Get italyQuantity
     *
     * @return string
     */
    public function getItalyQuantity()
    {
        return $this->italyQuantity;
    }

    /**
     * Set usaLength
     *
     * @param string $usaLength
     *
     * @return TyrePallet
     */
    public function setUsaLength($usaLength)
    {
        $this->usaLength = $usaLength;

        return $this;
    }

    /**
     * Get usaLength
     *
     * @return string
     */
    public function getUsaLength()
    {
        return $this->usaLength;
    }

    /**
     * Set usaWidth
     *
     * @param string $usaWidth
     *
     * @return TyrePallet
     */
    public function setUsaWidth($usaWidth)
    {
        $this->usaWidth = $usaWidth;

        return $this;
    }

    /**
     * Get usaWidth
     *
     * @return string
     */
    public function getUsaWidth()
    {
        return $this->usaWidth;
    }

    /**
     * Set usaQuantity
     *
     * @param string $usaQuantity
     *
     * @return TyrePallet
     */
    public function setUsaQuantity($usaQuantity)
    {
        $this->usaQuantity = $usaQuantity;

        return $this;
    }

    /**
     * Get usaQuantity
     *
     * @return string
     */
    public function getUsaQuantity()
    {
        return $this->usaQuantity;
    }
}
