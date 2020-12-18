<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Klass;
use App\Models\Media;
use Illuminate\Http\Request;

class MyVideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request , $type = "")
    {
        $builder = Media::where('status', 'Visible')->where("attachment_type", $type == "books" ? "Document" : "Video")->orderby('title', 'asc');

        if (!empty($key = $request['keyword'])) {
            $builder = $builder->where('title', 'like', "%$key%")->orWhereHas('subject', function ($query) use ($key) {
                $query->where('name', 'like', "%$key%");
            });
        }
        if (!empty($key = $request['class'])) {
            $builder = $builder->where('klass_id', 'like', "%$key%");
        }
        if (!empty($key = $request['term'])) {
            $builder = $builder->where('term', 'like', "%$key%");
        }

        $user = auth()->user();
        $media = $builder->paginate(20);
        $title = ucfirst($type);
        $url = route("media_collection.index", $type);
        $classes = Klass::orderby("name")->get();
        $terms = getTerms();
        $requestData = [
            "keyword" => $request['keyword'],
            "class" => $request['class'],
            "term" => $request['term'],
        ];
        return view('user.my_videos.index', compact('user', 'media', 'title', 'url', 'requestData', 'classes', 'terms'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
