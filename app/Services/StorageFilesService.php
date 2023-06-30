<?php

namespace App\Services;

use App\Classes\Convertors\ConvertFile;
use App\Classes\Convertors\Drivers\InterventionImageDriver;
use App\Services\Contracts\StorageFilesServiceContract;
use Illuminate\Support\Facades\Storage;

class StorageFilesService implements StorageFilesServiceContract
{
    private $images;
    private $videos;

    public function storageFiles()
    {
        $filesPaths = [
            'images' => [],
            'videos' => [],
        ];
        $images = $this->getImages();
        $videos = $this->getVideos();
        if (!empty($images)) {
            foreach ($images as $image) {
                $image = (new ConvertFile(new InterventionImageDriver()))->setFile($image)
                                                                         ->convertFile()
                                                                         ->storage('files/query/images/');

                $filesPaths['images'][] = $image;
            }
        }
        if (!empty($videos)) {
            foreach ($videos as $video) {
                $filesPaths['videos'][] = Storage::putFile('files/query/videos', $video, 'public');
            }
        }

        return $filesPaths;
    }

    /**
     * @return mixed
     */
    public function getImages()
    {
        return $this->images;
    }

    public function setImages($images)
    {
        $this->images = $images;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getVideos()
    {
        return $this->videos;
    }


    public function setVideos($videos)
    {
        $this->videos = $videos;
        return $this;
    }

    /**
     * @return array[]
     */
    public function getFilesPaths() : array
    {
        return $this->filesPaths;
    }
}