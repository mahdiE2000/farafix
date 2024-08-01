<?php

namespace App\Services\Media\UrlGenerator;

use DateTimeInterface;
use Spatie\MediaLibrary\Support\UrlGenerator\DefaultUrlGenerator;

class FtpUrlGenerator extends DefaultUrlGenerator
{
    /**
     * Get the url for the profile of a media item.
     *
     * @return string
     */
    public function getUrl() : string
    {
        return config('media-library.wm-cdn').'/'.$this->getPathRelativeToRoot();
    }

    /**
     * @param DateTimeInterface $expiration
     *
     * @param array $options
     *
     * @return string
     */
    public function getTemporaryUrl(DateTimeInterface $expiration, array $options = []): string
    {
        return 'done';
    }

    /**
     * Get the relative path for the profile of a media item.
     *
     * @return string
     *
     */
    public function getPath():string
    {
        return $this->getPathRelativeToRoot();
    }

    /**
     * Get the url to the directory containing responsive images.
     *
     * @return string
     */
    public function getResponsiveImagesDirectoryUrl(): string
    {
        return config('media-library.wm-cdn').'/'.$this->pathGenerator->getPathForResponsiveImages($this->media);
    }
}
