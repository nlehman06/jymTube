<?php


namespace App\StreamingServices;


use App\Video;
use Carbon\Carbon;
use DateInterval;
use DateTime;
use Exception;
use Youtube;

class YouTubeService implements StreamingServiceInterface {

    private $errorData, $urlData, $errorsExist;

    /**
     * YouTubeService constructor.
     */
    public function __construct()
    {
        $this->errorData = [
            'message'               => 'We couldn\'t find the video from YouTube',
            'message_from_provider' => '',
            'other_info'            => ''
        ];
        $this->urlData = [];
        $this->errorsExist = false;
    }

    /**
     * Checks if the processing of the url has caused any errors
     * @return bool
     */
    public function hasErrors()
    {
        return $this->errorsExist;
    }

    /**
     * Returns the array of friendly error information
     * @return array
     */
    public function getErrorData()
    {
        return $this->errorData;
    }

    /**
     * Parse the url and return the video id
     * @param $url
     * @return mixed
     */
    public function getIdFromUrl($url)
    {
        $videoId = null;
        try
        {
            $videoId = Youtube::parseVidFromURL($url);
        } catch (Exception $e)
        {
            $this->errorData['other_info'] = $e->getMessage();
            $this->errorsExist = true;
        }

        return $videoId;
    }

    /**
     * Call Provider api and try and find the video data
     *
     * @param $videoId
     * @return array
     */
    public function getDataFromProvider($videoId)
    {
        $urlData = [];
        try
        {
            $video = Youtube::getVideoInfo($videoId);
            if ($video)
            {
                $channel = Youtube::getChannelById($video->snippet->channelId);
                $urlData = [
                    'provider'      => 'youtube',
                    'provider_id'   => $video->id,
                    'title'         => $video->snippet->title,
                    'description'   => $video->snippet->description,
                    'permalink_url' => 'https://www.youtube.com/watch?v=' . $video->id,
                    'length'        => $this->convertTime($video->contentDetails->duration),
                    'picture'       => $video->snippet->thumbnails->medium->url,
                    'created_time'  => Carbon::parse($video->snippet->publishedAt)->format('Y-m-d H:i:s'),
                    'from_id'       => $video->snippet->channelId,
                    'from_name'     => $video->snippet->channelTitle,
                    'from_profile'  => $channel->snippet->thumbnails->default->url,
                    'content_tags'  => '',
                    'custom_labels' => ''
                ];
            } else
            {
                $this->errorData['other_info'] = "Can't find this video using ID: " . $videoId;
                $this->errorsExist = true;
            }
        } catch (Exception $e)
        {
            $this->errorData['message_from_provider'] = $e->getMessage();
            $this->errorsExist = true;
        }

        return $urlData;
    }

    /**
     * Make sure there isn't anything already in the database matching this video
     * @param $videoId
     * @return mixed
     */
    public function checkOriginality($videoId)
    {
        $videoExists = Video::whereProvider('youtube')
            ->whereProviderId($videoId)
            ->exists();
        if ($videoExists)
        {
            $this->errorsExist = true;
            $this->errorData['other_info'] = "This video has already been submitted.";

            return false;
        }

        return true;
    }

    private function convertTime($youtube_time)
    {
        $start = new DateTime('@0'); // Unix epoch
        try
        {
            $start->add(new DateInterval($youtube_time));
        } catch (Exception $e)
        {
            $this->errorData['message_from_provider'] = $e->getMessage();
            $this->errorsExist = true;
        }

        return $start->format('H:i:s');
    }
}