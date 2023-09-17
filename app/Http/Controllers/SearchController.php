<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function trendingsearch(Request $request){
        // dd($request);
       $trending = CurlAPI("pages/trendingsearch", 'POST', '' , 1);
       // dd($trending);
       if($trending['success'] == 'true' && $trending['contents'] != ''){
         $trendingData = $trending['contents'];
       }else{
         $trendingData = '';
       }
       return view('pages.search.search')->with('trendingData',$trendingData);
    }

    public function search(Request $request)
    {
        $searchText = $request->post('searchinput');
        $postData = [
            'searchTerm' => $searchText,
        ];

        $searchResult = CurlAPI("pages/search", 'POST', $postData, 1);

        if ($searchResult['success'] == true) {
            $data = [];

            // Define a mapping of category titles to response keys
            $categoryMapping = [
                'All' => 'AlltopResult',
                'Movies' => 'MoviestopResult',
                'Shows' => 'ShowstopResult',
                'Podcasts' => 'PodcaststopResult',
                'Kids' => 'KidstopResult',
                'Games' => 'GamestopResult',
            ];

            foreach ($searchResult['contents'] as $val) {
                $title = $val['title'];

                if (isset($categoryMapping[$title])) {
                    $categoryKey = $categoryMapping[$title];
                    $data[$categoryKey] = generateCategoryResponse($val);
                }
            }

            return json_encode($data);
        } else {
            // Handle the case when the search is not successful
            return JSONResponse(400, 'Error.');
        }
    }

}
