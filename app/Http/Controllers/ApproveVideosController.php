<?php

namespace App\Http\Controllers;

use App\Tag;
use App\Video;
use function array_map;
use function compact;
use Illuminate\Http\Request;
use Response;

class ApproveVideosController extends Controller {

    /**
     * ApproveVideosController constructor.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'permission:approve videos']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $videos = Video::submitted()->latest()->get();

        return view('approveVideos.index', compact('videos'));
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
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Video $video
     * @return \Illuminate\Http\Response
     */
    public function edit(Video $video)
    {
        return view('approveVideos.edit', compact('video'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Video $video
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Video $video)
    {
        $data = request()->validate([
            'selectedTags' => 'required|array|min:1'
        ]);

        $tags = array_map(function ($tag) {
            return Tag::firstOrCreate(['name' => $tag])->id;
        }, $data['selectedTags']);

        $video->tags()->sync($tags);

        $video->update(['status' => 'approved']);

        return Response::json(['successful' => true], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
