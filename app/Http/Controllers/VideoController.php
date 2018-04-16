<?php

namespace App\Http\Controllers;

use App\Video;
use function env;
use Exception;
use Facebook\Exceptions\FacebookSDKException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use SammyK\LaravelFacebookSdk\LaravelFacebookSdk;
use function url;
use function view;

class VideoController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('video.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Video $video
     * @return \Illuminate\Http\Response
     */
    public function show(Video $video)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Video $video
     * @return \Illuminate\Http\Response
     */
    public function edit(Video $video)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Video $video
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Video $video)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Video $video
     * @return void
     */
    public function destroy(Video $video)
    {
        //
    }

    public function checkURL(Request $request, LaravelFacebookSdk $fb)
    {
        $data = $request->validate(['url' => 'required']);

        $error_data = [
            'message'               => "We couldn't find this video on Facebook",
            'message_from_provider' => '',
            'other_info'            => ''
        ];

        preg_match("#(\d+)/$#", $data['url'], $vid);

        if (!count($vid))
        {
            $error_data['other_info'] = "No id found";

            return Response::json(['success' => false, 'error_data' => $error_data], 302);
        }

        try
        {
            $response = $fb->sendRequest(
                'GET',
                '/' . $vid[1],
                [
                    'fields' => 'title,content_tags,created_time,custom_labels,description,from{id,name,picture},length,permalink_url,picture,source'
                ],
                env('FACEBOOK_ACCESS_TOKEN'))->getGraphNode();

            $url_data = [
                'provider'      => 'facebook',
                'provider_id'   => $response->getField('id'),
                'title'         => $response->getField('title'),
                'description'   => $response->getField('description'),
                'permalink_url' => $response->getField('permalink_url'),
                'length'        => $response->getField('length'),
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

            return Response::json(['success' => false, 'error_data' => $error_data], 302);
        }

        return Response::json(['success' => true, 'url_data' => $url_data], 201, [], JSON_NUMERIC_CHECK);
    }
}
