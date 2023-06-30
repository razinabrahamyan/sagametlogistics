<?php

namespace App\Classes\Convertors;

use App\Classes\Convertors\Drivers\DriverInterface;
use Illuminate\Support\Facades\Storage;

class ConvertFile implements ConvertFileInterface, StorageFileInterface
{
    private $driver;
    private $file;
    private $convertedFile;

    /**
     * ConvertFile constructor.
     * @param DriverInterface $driver
     */
    public function __construct(DriverInterface $driver)
    {
        $this->setDriver($driver);
    }

    /**
     * @return $this
     */
    public function convertFile() : ConvertFile
    {
        $driver = $this->getDriver();
        $convertor = (new $driver)->setFile($this->getFile())->convert();
        $this->setConvertedFile($convertor);
        return $this;
    }

    /**
     * @param $path
     * @param string $options
     * @return string
     */
    public function storage($path, $options = 'public') : string
    {
        $driver = $this->getDriver();
        $hash = md5($this->getConvertedFile().now()->__toString());
        Storage::put($path.$hash.'.'.$driver->getFormat(), $this->getConvertedFile(), 'public');

        return $path.$hash.'.'.$driver->getFormat();
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
     * @return ConvertFile
     */
    public function setFile($file)
    {
        $this->file = $file;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDriver()
    {
        return $this->driver;
    }

    /**
     * @param mixed $driver
     * @return ConvertFile
     */
    public function setDriver($driver) : ConvertFile
    {
        $this->driver = $driver;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getConvertedFile()
    {
        return $this->convertedFile;
    }

    /**
     * @param mixed $convertedFile
     * @return ConvertFile
     */
    public function setConvertedFile($convertedFile) : ConvertFile
    {
        $this->convertedFile = $convertedFile;
        return $this;
    }
}