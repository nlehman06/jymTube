<?php

namespace App\StreamingServices;

use Facebook\Exceptions\FacebookSDKException;
use SammyK\LaravelFacebookSdk\LaravelFacebookSdk;

class FacebookService implements StreamingServiceInterface {

    private $errorData, $urlData, $errorsExist;
    /**
     * @var LaravelFacebookSdk
     */
    private $fb;


    /**
     * FacebookService constructor.
     */
    public function __construct()
    {
        $this->errorData = [
            'message'               => 'We couldn\'t find the video from Facebook',
            'message_from_provider' => '',
            'other_info'            => ''
        ];
        $this->urlData = [];
        $this->errorsExist = false;
        $this->fb = app(LaravelFacebookSdk::class);
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
        preg_match("#(\d+)/$#", str_finish($url, '/'), $vid);

        if (!count($vid))
        {
            $this->errorsExist = true;
            $this->errorData['other_info'] = "No id found";

            return null;
        }

        return $vid[1];
    }

    /**
     * Call Facebook graph api and try and find the video data
     *
     * @param $videoId
     * @return array
     */
    public function getDataFromProvider($videoId)
    {
        $urlData = [];
        try
        {
            $response = $this->fb->sendRequest(
                'GET',
                '/' . $videoId,
                [
                    'fields' => 'title,content_tags,created_time,custom_labels,description,from{id,name,picture},length,permalink_url,picture,source'
                ],
                env('FACEBOOK_ACCESS_TOKEN'))->getGraphNode();

            $urlData = [
                'provider'      => 'facebook',
                'provider_id'   => $response->getField('id'),
                'title'         => $response->getField('title'),
                'description'   => $response->getField('description'),
                'permalink_url' => 'https://www.facebook.com/' . $response->getField('permalink_url'),
                'length'        => $this->convertTime($response->getField('length')),
                'picture'       => $response->getField('picture'),
                'created_time'  => $response->getField('created_time')->format('Y-m-d H:i:s'),
                'from_id'       => $response->getField('from')->getField('id'),
                'from_name'     => $response->getField('from')->getField('name'),
                'from_profile'  => $response->getField('from')->getField('picture')->getField('url'),
                'content_tags'  => $response->getField('content_tags'),
                'custom_labels' => $response->getField('custom_labels')
            ];
        } catch (FacebookSDKException $e)
        {
            $error_data['message_from_provider'] = $e->getMessage();

            $this->errorsExist = true;
        }

        return $urlData;

    }

    private function convertTime($seconds)
    {
        $t = round($seconds);

        return sprintf('%02d:%02d:%02d', ($t / 3600), ($t / 60 % 60), $t % 60);
    }
}