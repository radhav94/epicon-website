 <?php
 
 $subtext = [];
 if (@$v_content['age_limit']) {
     $subtext[] = $v_content['age_limit'];
 }
 
 $genres = array_column($v_content['genres_assign'] ?? [], 'name');
 
 if ($genres) {
     foreach ($genres as $key => $genre) {
         if ($key > 2) {
             break;
         }
         $subtext[] = $genre;
     }
 }
 
 if (isset($v_content['release_date'])) {
     $subtext[] = date('Y', strtotime($v_content['release_date']));
 }
 ?>

 {{ implode(' • ', $subtext) }}
