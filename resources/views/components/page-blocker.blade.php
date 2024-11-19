<?php 
    $enable_pageblocker = false;

    $pageblocker = @$result['data']['pageblocker'] ?? [];

    if($pageblocker){
        $start_date = @$pageblocker['start_date'];
        $end_date = @$pageblocker['end_date'];
        $pb_link = !empty(@$pageblocker['link']) ? @$pageblocker['link'] : getUrl('/');

        $enable_pageblocker = @$pageblocker['status'] == 1 ? true : false;
        
        $today = date('Y-m-d');
        if($enable_pageblocker == true){

            if( !empty($start_date) && !empty($end_date) ){
                if ( $today >= $start_date && $today <= $end_date ) {
                    $enable_pageblocker = true;
                }else{
                    $enable_pageblocker = false;
                }
            }
            else if(!empty($start_date) && $today >= $start_date){
                 $enable_pageblocker = true;
            }
            else if(!empty($end_date) && $today <= $end_date){
                 $enable_pageblocker = true;
            }
            else {
                 $enable_pageblocker = false;
            }
        }

        $pb_image = isMobliDevice() ? @$pageblocker['mobile_image'] : @$pageblocker['desktop_image'];
    }
  
     
?>
<!-- page blocker start -->
@if($enable_pageblocker)
<div class="modal page-blocker" tabindex="-1">
  <div class="modal-dialog page-dialog modal-dialog-centered modal-lg">
    <div class="modal-content blocker-content">
    <button class="close-button page-close" onclick="closeModal()">&times;</button>
        <div class="modal-body blocker-body" data-url="{{ $pb_link }}">
            <a href="{{ @$pb_link }}" target="_blank"><img src="{{ $pb_image }}" alt="banner"> </a>
        </div> 
    </div>
  </div>
</div>
@endif
<!-- page blocker end -->