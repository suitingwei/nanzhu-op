<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\MovieLock;
use App\User;
use DB;
use Illuminate\Http\Request;

class MoviesController extends Controller
{
    private $companyUserPhones = [
        '18911862431',
        '13521763323',
        '17343093323',
        '13718139810',
        '15810608173',
        '15001316980',
        '18611660502',
        '13910313773',
        '13439308668',
        '13290755688',
        '15101019986'
    ];

    public function index(Request $request)
    {
        $old_types = Movie::old_types();
        $name      = $request->get("name");
        $shootend  = $request->get("shootend", 0);
        $type      = $request->get("type");

        $currentUserId = session()->get('user_id');

        if ($currentUserId == 21100) {
            $companyUserIdArray = User::whereIn('FPHONE', $this->companyUserPhones)
                                      ->selectRaw('distinct FID')
                                      ->lists('FID')
                                      ->all();
            $movieIdArray       = Movie::whereIn('FNEWUSER', $companyUserIdArray)
                                       ->selectRaw('distinct FID')
                                       ->lists('FID')->all();
        }

        $movies = Movie::orderBy('fnewdate', 'desc');

        if (isset($movieIdArray)) {
            $movies = $movies->whereNotIn('FID', $movieIdArray);
        }

        if ($name) {
            $movies = $movies->where("FNAME", "like", "%" . $name . "%");
        }
        if ($type) {
            $movies = $movies->where("FTYPE", $type);
        }
        if ($shootend) {
            $movies = $movies->where("shootend", $shootend);
        }

        $movies = $movies->paginate(100);

        return view("admin.movies.index", ["movies" => $movies, "old_types" => $old_types]);

    }

    public function show(Request $request, $id)
    {
        $movie = Movie::where("FID", $id)->first();

        return view("admin.movies.show", ["movie" => $movie]);
    }

    public function edit(Request $request, $id)
    {
        $movie = DB::table('t_biz_movie')
                   ->selectRaw('t_biz_movie.FID as FID, t_biz_movie.ftype as flabel, t_biz_movie.FNAME as fname,t_biz_movie.shootend as shootend')
                   ->where("t_biz_movie.FID", $id)
                   ->get();
        return view("admin.movies.edit", ["movie" => $movie]);
    }

    public function update(Request $request, $id)
    {
        DB::table('t_biz_movie')
          ->where('fid', $id)
          ->update(['shootend' => $request->get("shootend")]);
        return redirect()->to("/admin/movies")->with("message", "创建成功");
    }

    public function users()
    {

    }

    public function lock($movieId,Request $request)
    {
        MovieLock::create(['movie_id'=>$movieId]);
        return redirect('/admin/movies');
    }

    public function unlock($movieId)
    {
        MovieLock::where(['movie_id'=>$movieId])->delete();
        return redirect('/admin/movies');
    }
}


