<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function trendingsearch(Request $request)
    {
        // dd($request);
        $trending = CurlAPI("pages/trendingsearch", 'POST', '', 1);
        // dd($trending);
        if ($trending && (@$trending['success'] == 'true' || @$trending['success'] == true)) {
            $trendingData = $trending['contents'] ?? [];
            return view('pages.search.search')->with('trendingData', $trendingData);
        } else {
            return view('pages.error.404');
        }
    }

    public function search(Request $request)
    {
        $searchText = $request->post('searchinput');
        $searchArray = session()->has('searchHistory') ? session('searchHistory') : [];
        $searchArray[] = $searchText;
        session()->put('searchHistory', $searchArray);
        $postData = [
            'searchTerm' => $searchText,
        ];

        $searchResult = CurlAPI("pages/search", 'POST', $postData, 1);
        if ($searchResult) {
            $data = [];

            // Define a mapping of category titles to response keys
            $categoryMapping = [
                'All' => 'AllResult',
                'Movies' => 'MoviesResult',
                'Shows' => 'ShowsResult',
                'Podcasts' => 'PodcastsResult',
                'Kids' => 'KidsResult',
                'Games' => 'GamesResult',
            ];

            if (key_exists('contents', $searchResult)) {
                foreach ($searchResult['contents'] as $val) {
                    $title = $val['title'];

                    if (isset($categoryMapping[$title])) {
                        $categoryKey = $categoryMapping[$title];
                        $data['topResult'][$categoryKey] = generateCategoryResponse($val);
                    }

                    if (isset($categoryMapping[$title])) {
                        $categoryKey = $categoryMapping[$title];
                        $data['otherResult'][$categoryKey] = $this->getOtherResult($val);
                    }
                }
            }

            return JSONResponse(200, '', ['data' => $data, 'success' => @$searchResult['success']]);
        } else {
            return JSONResponse(400, "Something went wrong. Please try again!");
        }
    }

    private function getOtherResult($content)
    {
        if (empty($content) || !isset($content['content'])) {
            return '';
        }

        $contents = @$content['content'];
        $htmlContent = "";
        if ($contents) {
            $htmlContent = '<div class="carousel-main">
                            <h5 class="text-white">Other Results</h5>
                            <ul class="more-like-this carousel-initilize p-0">';
            foreach ($contents as $content) {
                $cover_img = getCardImage($content, 'cover_image', 'small');
                $htmlContent .= '<li>
                                <a href="javascript:void(0);" class="main-card mt-0">
                                    <div class="main-img mt-0">
                                        <img src="' . $cover_img . '" alt="">
                                    </div>
                                </a>
                            </li>';
            }
            $htmlContent .= '</ul></div>';
        } else {
            $htmlContent = '<p style="text-align:center;color:#fff">' . __('No Results Found') . '</p>';
        }

        return $htmlContent;
    }
}
