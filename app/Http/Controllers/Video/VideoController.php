<?php

namespace App\Http\Controllers\Video;

use App\Http\Controllers\Controller;
use App\Http\Resources\Video\Course as CoursesVideo;
use App\Http\Resources\Video\Video as VideoVideo;
use App\Http\Resources\Video\VideoCollection;
use App\Models\Courses;
use App\Models\Kelas;
use App\Models\Student;
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
        if($user->id_role !== 23) {
            $courses = Courses::with('category_courses')
            ->whereHas('kelas' , function($q) use($user) {
                    $q->where('id_trainer',$user->id);
            })
            ->whereHas('category_courses', function($q) {
                $q->where('description','!=','Career Program');
            })->get();
        } else {
            $courses = Courses::with('category_courses')
            ->whereHas('category_courses', function($q) {
                $q->where('description','!=','Career Program');
            })->get();
        }
        return response()->json([
            'data' => $courses
        ]);
    }

    public function student_courses(){
        $user = $this->user;
        $kelas = Kelas::with('courses')->whereHas('students',function ($q) use($user) {
            $q->where('id_user',$user->id);
        })->get();
        $courses = [];
        foreach ($kelas as $value) {
            if ($value->courses->category_courses->description == 'Career Program') {
                $data = Courses::where('id_category',$value->courses->id_category)
                ->whereHas('category_courses',function($q) {
                    $q->where('description','!=','Career Program');
                })->get();
                foreach ($data as $course) {
                    if (!in_array($course,$courses)) {
                        array_push($courses,$course);
                    }
                }
            }else {
                unset($value->courses['category_courses']);
                if (!in_array($value->courses,$courses)) {
                    array_push($courses,$value->courses);
                }
               
            };
            
        }
        return response()->json([
            'data' => $courses
        ]);;
    }

    public function student_video(Request $request, $slug) {
        $video = Video::where('nama_video','LIKE',"%{$request->keyword}%")
        ->whereHas('courses' , function($q) use($slug) {
            $q->where('slug',$slug);
        })->orderBy('created_at','desc')->paginate(12);
        return new VideoCollection($video);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $video = Video::whereHas('courses' , function($q) use($request) {
            $q->where('slug',$request->slug);
        })->orderBy('created_at','desc')->paginate(12);
        return new VideoCollection($video);

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
