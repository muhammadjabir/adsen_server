<?php

namespace App\Http\Controllers\Video;

use App\Http\Controllers\Controller;
use App\Http\Resources\Video\Course;
use App\Http\Resources\Video\VideoCollection;
use App\Models\Courses;
use App\Models\Kelas;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $user;

    public function __construct()
    {
        $this->user = \Auth::user();
    }
    public function index()
    {
        $user = $this->user;
        $kelas = Kelas::with(['courses'])->select('id_kursus')->where(function($q) use($user) {
            if($user->id_role !== 23) {
                return $q->where('id_trainer',$user->id);
            } 
        })->get();
        $courses = [];
        foreach ($kelas as $value) {
            if (!in_array($value->courses,$courses)) {
                array_push($courses,$value->courses);
            }
        
        }
        return response()->json([
            'data' => $courses
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $courses = Courses::where('slug',$request->slug)->first();
        $video = Video::where('id_courses',$courses->id)->paginate(2);
        $data = new VideoCollection($video);

        return [$data,$courses];
        // return new Course($courses);
        return response()->json([
            'id' => $courses->id,
            'slug' => $courses->slug,
            'name' => $courses->name,
            'videos' => $data->data,
            'links' =>  $data->links,
            'meta' => $data->meta
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $courses = Courses::select('id','slug')->where('slug',$request->slug)->first();
        $video = new Video;
        $video->nama_video = $request->nama;
        $video->id_courses = $courses->id;
        $file = $request->file('video')->store('video\video_courses','public');
        $video->video = $file;
        $video->id_user = $this->user->id;
        $video->save();
        return response()->json([
            'message' => 'Success Save Video'
        ]);
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
        $video = Video::findOrFail($id);
        $video->nama_video = $request->nama;
        $video->id_user = $this->user->id;
        if ($request->file('video')) {
            $file = $request->file('video')->store('video\video_courses','public');
            $video->video = $file;
        }
       
        $video->save();
        return response()->json([
            'message' => 'Success Edit Video'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $video = Video::findOrFail($id);
        $video->delete();
        return response()->json([
            'message' => 'Success Delete Video'
        ],200);
    }
}
