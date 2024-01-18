@extends('layouts.default')
@section('title','Transaction History')
 

@section('content')

    <section class="container w-100 my-4">
        <div class="row justify-content-center">
            <div class="col-sm-12">
                    <h4 class="text-white border-bot pb-4 mb-0">
                       <a href="{{getUrl('my-account')}}" class="text-decoration-none">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 32 32" fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M27 16.6667C27 17.219 26.5523 17.6667 26 17.6667L7.33333 17.6667C6.78105 17.6667 6.33333 17.219 6.33333 16.6667C6.33333 16.1144 6.78105 15.6667 7.33333 15.6667L26 15.6667C26.5523 15.6667 27 16.1144 27 16.6667Z" fill="white"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M17.3738 26.7071C16.9832 27.0976 16.3501 27.0976 15.9596 26.7071L6.62623 17.3738C6.23571 16.9832 6.23571 16.3501 6.62623 15.9596L15.9596 6.62623C16.3501 6.2357 16.9833 6.2357 17.3738 6.62623C17.7643 7.01675 17.7643 7.64992 17.3738 8.04044L8.74755 16.6667L17.3738 25.2929C17.7643 25.6834 17.7643 26.3166 17.3738 26.7071Z" fill="white"/>
                          </svg>
                       </a>&nbsp; {{__('Transaction History')}}
                    </h4>
            </div>
            
            <div class="col-sm-12 d-flex align-items-center">
                <div class="trasaction-table table-responsive w-100">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>{{__('Plan')}}</th>
                            <th>{{__('Source')}}</th>
                            <th>{{__('Start Date')}}</th>
                            <th>{{__('End Date')}}</th>
                            <th class="text-end">{{__('Total')}}</th>
                        </tr>
                        </thead>
                      
                        <tbody>
                    @if(!empty($subscriptionPurchases))
                        @foreach($subscriptionPurchases as $key => $value)
                        @php
                        $subs_start_date = $value['subscription_start_date'];
                        $start_date = new DateTime($subs_start_date);
                        $subs_start_date = $start_date->format('d/m/y');

                        $subs_end_date = $value['subscription_end_date'];
                        $end_date = new DateTime($subs_end_date);
                        $subs_end_date = $end_date->format('d/m/y');
                        
                        @$validity_days = $value['validity_days'];
                        $plan_name = '';

                        $sub_source = (isset($value['device'])) ? ucfirst(preg_replace('/_+/', ' ', $value['device'])) : ' - ';

                        switch ($validity_days) {
                            case 30:
                                $plan_name = '1 Month';
                                break;
                            case 90:
                                $plan_name = '3 Months';
                                break;
                            case 180:
                                $plan_name = '6 Months';
                                break;
                            case 365:
                                $plan_name = '1 Year';
                                break;
                            default:
                                $plan_name = 'Active';
                                break;
                        }
                        

                        @endphp
                            <tr>
                                <td>{{$plan_name}}</td>
                                <td>{{$sub_source}}</td>
                                <td>{{ isset($subs_start_date) ? $subs_start_date : '' }} </td>
                                {{--<!-- <td><img src="{{ asset('/img/visa.svg') }}" alt="icon" class="me-2">visa **** **** **** 1823</td> -->--}}
                                <td>{{ isset($subs_end_date) ? $subs_end_date : '' }}</td>
                                <td class="text-end">
                                    @if( isset($value['plan_amount']) )
                                        {!! getCurrency($value['currency']) !!} {{ $value['plan_amount'] }}
                                    @else
                                        — &nbsp; 
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                          <td colspan="4">{{__('text.myaccount-history-not-found')}}</td>
                        </tr>
                    @endif
                        </tbody>
                        
                    </table>
                </div>
            </div>
        </div>
    </section>
    
@stop

@section('script')


@stop