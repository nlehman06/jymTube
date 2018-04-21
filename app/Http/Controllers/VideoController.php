<?php

namespace App\Http\Controllers;

use App\StreamingServices\FacebookService;
use App\StreamingServices\StreamingService;
use App\StreamingServices\StreamingServiceInterface;
use App\StreamingServices\YouTubeService;
use App\Video;
use function class_exists;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use function strpos;
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store()
    {
        $data = request()->validate([
            'provider'      => 'required',
            'provider_id'   => 'required',
            'title'         => 'required',
            'description'   => 'required',
            'permalink_url' => 'required|url',
            'length'        => 'required|date_format:"H:i:s"',
            'picture'       => 'required|url',
            'created_time'  => 'required|date_format:"Y-m-d H:i:s"',
            'from_id'       => 'required',
            'from_name'     => 'required',
            'from_profile'  => 'required|url'
        ]);

        $data['submitted_date'] = now();

        auth()->user()->submittedVideos()->create($data);

        return Response::json([], 201);
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

    public function checkURL(Request $request)
    {
        $data = $request->validate(['url' => 'required']);

        $provider = $this->determineProvider($url = $data['url']);

        if (!class_exists($provider))
        {
            $error_data['message'] = "We couldn't determine the provider from the given URL";
            $error_data['other_info'] = "As of right now, we only support videos from Facebook or YouTube.";

            return Response::json(['success' => false, 'error_data' => $error_data], 302);
        }

        /** @var StreamingService $videoService */
        $videoService = new StreamingService(new $provider);

        $videoService->process($url);

        if ($videoService->hasErrors())
        {
            return Response::json(['success' => false, 'error_data' => $videoService->errorData], 302);
        }

        return Response::json(['success' => true, 'url_data' => $videoService->urlData], 201);

    }

    /**
     * @param $url
     * @return null|string
     */
    private function determineProvider($url)
    {
        $youTubeUrls = ['youtube.com', 'youtu.be'];
        $facebookUrls = ['facebook.com'];

        foreach ($youTubeUrls as $youTubeUrl)
        {
            if (strpos($url, $youTubeUrl) !== false)
            {
                return YouTubeService::class;
            }
        }

        foreach ($facebookUrls as $facebookUrl)
        {
            if (strpos($url, $facebookUrl) !== false)
            {
                return FacebookService::class;
            }
        }

        return null;
    }
}
