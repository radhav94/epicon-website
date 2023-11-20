<?php 
    $blockerlink = (env('IS_PAGEBLOCKER_FREE_CONTENT')==true) ? getUrl(env('PAGEBLOCKER_LANDING_URL','/')) : getUrl('/');
                $ua = strtolower($_SERVER["HTTP_USER_AGENT"]);
                $isMob = is_numeric(strpos($ua, "mobile"));
                 if(isset($isMob) && $isMob==true){
                    if(!empty(env('PAGEBLOCKERDATE'))) {
                      $pageblockername = 'Mobile-Page-Blocks_'.env('PAGEBLOCKERDATE').'.jpg';
                  } else {
                      $pageblockername = 'Mobile-Page-Blocks.jpg';
                  }
                }else{
                     if(!empty(env('PAGEBLOCKERDATE'))) {
                        $pageblockername = 'Desktop-Page-Blocks_'.env('PAGEBLOCKERDATE').'.jpg';
                    } else {
                        $pageblockername = 'Desktop-Page-Blocks.jpg';
                    }
                }      
?>
<!-- page blocker start -->
@if(env('ENABLE_PAGEBLOCKER') == 1)
<div class="modal page-blocker" tabindex="-1">
  <div class="modal-dialog page-dialog modal-dialog-centered modal-lg">
    <div class="modal-content blocker-content">
    <button class="close-button page-close" onclick="closeModal()">&times;</button>
        <div class="modal-body blocker-body" data-url="{{ config('epicconfig.PAGEBLOCKER.PAGEBLOCKER_URL') }}">
            <a href="{{ @$blockerlink }}" target="_blank"><img src="{{ asset('/img/'.@$pageblockername) }}" alt=""> </a>
        </div> 
    </div>
  </div>
</div>
@endif
<!-- page blocker end -->