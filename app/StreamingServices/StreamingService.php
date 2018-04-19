<?php

namespace App\StreamingServices;

use function count;

class StreamingService {

    /**
     * @var StreamingServiceInterface
     */
    private $provider;

    public $urlData, $errorData;

    /**
     * StreamingService constructor.
     * @param StreamingServiceInterface $provider
     */
    public function __construct(StreamingServiceInterface $provider)
    {
        $this->provider = $provider;
        $this->urlData = [];
        $this->errorData = [];
    }

    public function process($url)
    {
        $videoId = $this->provider->getIdFromUrl($url);

        if ($videoId)
            $this->urlData = $this->provider->getDataFromProvider($videoId);

        $this->errorData = $this->provider->getErrorData();
    }

    public function hasErrors()
    {
        return $this->provider->hasErrors();
    }
}