<?php

namespace App\StreamingServices;

interface StreamingServiceInterface {

    /**
     * Checks if the processing of the url has caused any errors
     * @return bool
     */
    public function hasErrors();

    /**
     * Returns the array of friendly error information
     * @return array
     */
    public function getErrorData();

    /**
     * Parse the url and return the video id
     * @param $url
     * @return mixed
     */
    public function getIdFromUrl($url);

    /**
     * Call Provider api and try and find the video data
     *
     * @param $videoId
     * @return array
     */
    public function getDataFromProvider($videoId);

    /**
     * Make sure there isn't anything already in the database matching this video
     * @param $videoId
     * @return mixed
     */
    public function checkOriginality($videoId);
}