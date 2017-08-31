<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClientMovieRequirement;
use App\Facades\SimilarityFacade;
use App\Utils\SimilarityCaculator;
use Illuminate\Support\Str;
use Similarity;

class InvestmentsController extends Controller
{
    public function index()
    {
        $clients = ClientMovieRequirement::where('type', ClientMovieRequirement::TYPE_CLIENT)->paginate(2);


        $movies = ClientMovieRequirement::where('type', ClientMovieRequirement::TYPE_MOVIE)->get();

        foreach ($clients as &$client) {
            $movieData = collect();
            foreach ($movies as $movie) {
                $movieData->push([
                    'movie'             => $movie,
                    'invest_similarity' => SimilarityCaculator::clientMovieInvestSimilarity($client, $movie),
                    'movie_similarity'  => SimilarityCaculator::clientMovieInvestSimilarity($client, $movie),
                    'reward_similarity' => SimilarityCaculator::clientMovieInvestSimilarity($client, $movie),
                    'date_similarity'   => SimilarityCaculator::clientMovieDateSimilarity($client, $movie, SimilarityCaculator::RANGE_SORT_DATE),
                    'budget_similarity' => SimilarityCaculator::clientMovieBudgetSimilarity($client, $movie),
                    'total_similarity'  => SimilarityCaculator::clientMovieSimilarity($client, $movie),
                ]);
            }
            $movieData             = $movieData->sortBy(function ($value, $key) {
                return floatval($value['total_similarity']);
            }, SORT_NUMERIC, true)->values()->take(3);
            $client['movies_data'] = $movieData;
        }
        return view('admin.investments.index', compact('clients'));
    }

}
