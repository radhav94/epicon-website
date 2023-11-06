<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function trendingsearch(Request $request)
    {
        $searchHistory  = session()->has('searchHistory') ? session()->get('searchHistory') : [];
        $kidsMode       = session()->has('kidsMode') ? session()->get('kidsMode') : false;
        $active_profile = session()->get('active_profile') ?? '';
        $searchArray    = $searchHistory[$active_profile] ?? [];
        $searchList     = "";

        if (count($searchArray) > 0) {
            krsort($searchArray);
            foreach ($searchArray as $val) {
                $searchList .= @$val['list'];
            }
        }

        $trending = CurlAPI("pages/trendingsearch", 'POST', '', 1);
        if ($trending && (@$trending['success'] == 'true' || @$trending['success'] == true)) {
            $trendingData = $trending['contents'] ?? [];
            return view('pages.search.search', compact('trendingData', 'searchList'));
        } else {
            return view('pages.error.404');
        }
    }

    public function search(Request $request)
    {   
        $searchText = $request->post('searchinput');
        $kidsMode = session()->has('kidsMode') ? session()->get('kidsMode') : false;
        if ($kidsMode == true) {
            $postData = [
                'searchTerm' => $searchText,
                'kids_content' => true
            ];
        } else {
            $postData = [
                'searchTerm' => $searchText,
            ];
        }
        
        $searchResult = CurlAPI("pages/search", 'POST', $postData, 1);
        // dd($searchResult);
        if ($searchResult) {
            $data = [];

            // Define a mapping of category titles to response keys
            $categoryMapping = [
                'All'       => 'AllResult',
                'Movies'    => 'MoviesResult',
                'Shows'     => 'ShowsResult',
                'Podcasts'  => 'PodcastsResult',
                'Kids'      => 'KidsResult',
                'Games'     => 'GamesResult',
            ];

            if (key_exists('contents', $searchResult)) {
                foreach ($searchResult['contents'] as $val) {
                    $title = $val['title'];

                    if (isset($categoryMapping[$title])) {
                        $categoryKey = $categoryMapping[$title];
                        $data['topResult'][$categoryKey] = $this->generateCategoryResponse($val);
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

    private function generateCategoryResponse($result)
    {
        if (empty($result) || !isset($result['topResult'])) {
            return '';
        }

        $topResult = $result['topResult'];

        $premium = ($topResult['free_premium'] == true) ? '<img class="crown" src="' . asset('assets/img/crown.svg') . '" alt="icon">' : '';
        $dateText = isset($topResult['release_date']) ? date('Y-m-d', strtotime($topResult['release_date'])) : '';
        $wishlist = getWishlist();
        $wishlistAction = getWishListAction($topResult, $wishlist, 2);
        

        $htmlContent = '<h5 class="text-white">Top Result</h5>'
            . '<ul class="list-unstyled col-12 col-sm-12 col-md-12 col-lg-10 col-xl-10 p-0 mt-4">';

        $cover_img = getCardImage($topResult, 'cover_image', 'medium');


        if(@$topResult['asset_type'] == 'PLAY'){
            $anchorHtml = getplayanchorhtml($topResult);
        }else{
            $anchorHtml = '<a href="'.getContentUrl($topResult).'" >';
        }
        

        $list = '<li class="episode-main mb-4">'
            . '<div class="pik"><img src="' . $cover_img . '" alt="img">' . $premium . '</div>'
            . '<div class="episode-text-details">'
            . '<h6>' . @$topResult['title'] . '</h6>'
            . '<span>' . @$dateText . ' | ' . @$topResult['duration'] . '</span>'
            . '<p class="search-top mt-2">' . sanitizeData(@$topResult['description']) . '</p>'
            . '<div class="d-flex align-items-center"> '.$anchorHtml.' <button class="fill-btn em ms-0">' . __('Watch') . '</button></a>' . $wishlistAction . '</div></div>'
            . '</li>';
        $htmlContent .= $list . '</ul>';
        $this->addHistorySession($list, @$topResult['title']);

        return $htmlContent;
    }

    private function addHistorySession($list = "", $title = "")
    {
        if (isUserLoggedIn()) {
            $searchHistory = session()->has('searchHistory') ? session()->get('searchHistory') : [];
            $active_profile = session()->get('active_profile') ?? '';
            $searchArray = $searchHistory[$active_profile] ?? [];

            if (count($searchArray) == 10) {
                array_splice($searchArray, 0, 1);
            } else {
                $key = array_search($title, array_column($searchArray, 'title'));
                if ($key !== false) {
                    array_splice($searchArray, $key, 1);
                }
                $searchArray[] = [
                    'title' => $title,
                    'list' => $list
                ];
            }

            $searchHistory[$active_profile] = $searchArray;
            session()->put('searchHistory', $searchHistory);
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
                $cover_img = getCardImage($content, 'cover_image', 'medium');

                if(@$content['asset_type'] == 'PLAY'){
                    $anchorHtml = getplayanchorhtml($content);
                }else{
                    $anchorHtml = '<a href="'.getContentUrl($content).'" class="main-card mt-0">';
                }
                
                $htmlContent .= '<li>
                                '.$anchorHtml.'
                                    <div class="main-img mt-0">
                                        <img src="' . $cover_img . '" alt="">
                                    </div>
                                </a>
                            </li>';
            }
            $htmlContent .= '</ul></div>';
        } else {
            $htmlContent = '<h5 class="text-white">Other Results</h5><p style="text-align:center;color:#fff">' . __('No Results Found') . '</p>';
        }

        return $htmlContent;
    }
}
