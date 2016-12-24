<?php
/**
 * Created by PhpStorm.
 * User: shan
 * Date: 12/21/16
 * Time: 9:02 PM
 */

namespace AppBundle\Packer;


use DVDoug\BoxPacker\Item;

class TestItem implements Item
{

    private $description;
    private $width;
    private $length;
    private $depth;
    private $weight;
    private $volume;
    private $keepflat;

    /**
     * TestItem constructor.
     * @param $description
     * @param $width
     * @param $length
     * @param $depth
     * @param $weight
     * @param $volume
     * @param $keepflat
     */
    public function __construct($description, $width, $length, $depth, $weight, $keepflat)
    {
        $this->description = $description;
        $this->width = $width;
        $this->length = $length;
        $this->depth = $depth;
        $this->weight = $weight;
        $this->volume = $length*$width*$depth;
        $this->keepflat = $keepflat;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param mixed $width
     */
    public function setWidth($width)
    {
        $this->width = $width;
    }

    /**
     * @return mixed
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @param mixed $length
     */
    public function setLength($length)
    {
        $this->length = $length;
    }

    /**
     * @return mixed
     */
    public function getDepth()
    {
        return $this->depth;
    }

    /**
     * @param mixed $depth
     */
    public function setDepth($depth)
    {
        $this->depth = $depth;
    }

    /**
     * @return mixed
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param mixed $weight
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;
    }

    /**
     * @return mixed
     */
    public function getVolume()
    {
        return $this->volume;
    }

    /**
     * @param mixed $volume
     */
    public function setVolume($volume)
    {
        $this->volume = $volume;
    }

    /**
     * @return mixed
     */
    public function getKeepflat()
    {
        return $this->keepflat;
    }

    /**
     * @param mixed $keepflat
     */
    public function setKeepflat($keepflat)
    {
        $this->keepflat = $keepflat;
    }



}