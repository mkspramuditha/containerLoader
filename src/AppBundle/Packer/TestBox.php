<?php

namespace AppBundle\Packer;

class TestBox implements \DVDoug\BoxPacker\Box
{
    private $reference;
    private $outerWidth;
    private $outerLength;
    private $outerDepth;
    private $emptyWeight;
    private $innerWidth;
    private $innerLength;
    private $innerDepth;
    private $maxWeight;
    private $innerVolume;

    public function __construct($aReference, $aOuterWidth,$aOuterLength,$aOuterDepth,$aEmptyWeight,$aInnerWidth,$aInnerLength,$aInnerDepth,$aMaxWeight) {
        $this->reference = $aReference;
        $this->outerWidth = $aOuterWidth;
        $this->outerLength = $aOuterLength;
        $this->outerDepth = $aOuterDepth;
        $this->emptyWeight = $aEmptyWeight;
        $this->innerWidth = $aInnerWidth;
        $this->innerLength = $aInnerLength;
        $this->innerDepth = $aInnerDepth;
        $this->maxWeight = $aMaxWeight;
        $this->innerVolume = $this->innerWidth * $this->innerLength * $this->innerDepth;
    }

    public function getReference() {
        return $this->reference;
    }

    public function getOuterWidth() {
        return $this->outerWidth;
    }

    public function getOuterLength() {
        return $this->outerLength;
    }

    public function getOuterDepth() {
        return $this->outerDepth;
    }

    public function getEmptyWeight() {
        return $this->emptyWeight;
    }

    public function getInnerWidth() {
        return $this->innerWidth;
    }

    public function getInnerLength() {
        return $this->innerLength;
    }

    public function getInnerDepth() {
        return $this->innerDepth;
    }

    public function getInnerVolume() {
        return $this->innerVolume;
    }

    public function getMaxWeight() {
        return $this->maxWeight;
    }


}