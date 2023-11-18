 <?php
    $chunks = array_chunk($result, 4);

    

        echo '<div class="card-details">';
        foreach ($chunks as $k => $chunk) {
        foreach ($chunk as $key => $val) {
            $cover_img = getCardImage($val, 'cover_image', 'small', ['cover_image', 'banner_image']);
            $banner_img = getCardImage($val, 'banner_image', 'medium', ['cover_image', 'banner_image']);
            $generes = array_column($val['genres_assign'] ?? [], 'name');

            $sub_text = [];

            if (isset($val['publish_start_date'])) {
                $date_text = date('Y', strtotime($val['publish_start_date']));
            }
            if (isset($val['publish_start_date'])) {
                $sub_text[] = date('Y', strtotime($val['publish_start_date']));
            }
            // $sub_text[] = '3 Language';

            if ($generes) {
                $sub_text[] = implode(" . ", $generes);
            }
            if (isset($val['age_limit'])) {
                $sub_text[] = $val['age_limit'];
            }


            $sub_points = (@$val['age_limit']) ? '<li class="ps-1">' . @$val['age_limit'] . '</li>' : '';

            if ($generes) {
                foreach ($generes as $key => $genre) {
                    $sub_points .= ' . ' . $genre;
                }
            }
            $wishlist = getWishlist();
    ?>

         <div class="card-body">
             {!! freePremiumDiv($val) !!}

             <a class="upper-img" href="{{ getContentUrl($val) }}">
                 <img src="{{ $cover_img }}" alt="">
             </a>
         </div>


 <?php
        }}
        echo '</div>';
     ?>