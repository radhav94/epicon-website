 <?php
 
 $subtext = [];
 if (@$v_content['age_limit']) {
     $subtext[] = $v_content['age_limit'];
 }
 
 $genres = array_column($v_content['genres_assign'] ?? [], 'name');
 
 if ($genres) {
     foreach ($genres as $key => $genre) {
         $subtext[] = $genre;
     }
 }
 
 if (isset($v_content['publish_start_date'])) {
     $sub_text[] = date('Y', strtotime($v_content['publish_start_date']));
 }
 
 ?>

 {{ implode(' • ', $subtext) }}
