<?php

namespace App\Classes\Convertors\Drivers;

use Intervention\Image\Facades\Image;

class InterventionImageDriver implements DriverInterface
{
    private $file;
    private $format = Constants::WEBP;
    private $quality = Constants::INTERVENTION_DEFAULT_QUALITY;

    /**
     * @return \Intervention\Image\Image
     */
    public function convert() : \Intervention\Image\Image
    {
        $image = Image::make($this->getFile())->encode($this->getFormat(), $this->getQuality());
        return $image;
    }

    /**
     * @return string
     */
    public function getFormat() : string
    {
        return $this->format;
    }

    /**
     * @param string $format
     * @return InterventionImageDriver
     */
    public function setFormat(string $format) : InterventionImageDriver
    {
        $this->format = $format;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param mixed $file
     * @return InterventionImageDriver
     */
    public function setFile($file)
    {
        $this->file = $file;
        return $this;
    }

    /**
     * @return int
     */
    public function getQuality() : int
    {
        return $this->quality;
    }

    /**
     * @param int $quality
     * @return InterventionImageDriver
     */
    public function setQuality(int $quality) : InterventionImageDriver
    {
        $this->quality = $quality;
        return $this;
    }

}