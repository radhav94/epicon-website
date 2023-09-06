@extends('layouts.default')
@section('title','New homepage')

@section('style')

@stop

@section('content')

    
    <section class="container w-100 my-4">
        <div class="row justify-content-center">
            <div class="col-sm-12">
                    <h4 class="text-white border-bot pb-4 mb-0">
                       <a href="my-account.html" class="text-decoration-none">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 32 32" fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M27 16.6667C27 17.219 26.5523 17.6667 26 17.6667L7.33333 17.6667C6.78105 17.6667 6.33333 17.219 6.33333 16.6667C6.33333 16.1144 6.78105 15.6667 7.33333 15.6667L26 15.6667C26.5523 15.6667 27 16.1144 27 16.6667Z" fill="white"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M17.3738 26.7071C16.9832 27.0976 16.3501 27.0976 15.9596 26.7071L6.62623 17.3738C6.23571 16.9832 6.23571 16.3501 6.62623 15.9596L15.9596 6.62623C16.3501 6.2357 16.9833 6.2357 17.3738 6.62623C17.7643 7.01675 17.7643 7.64992 17.3738 8.04044L8.74755 16.6667L17.3738 25.2929C17.7643 25.6834 17.7643 26.3166 17.3738 26.7071Z" fill="white"/>
                          </svg>
                       </a>&nbsp; Transaction History
                    </h4>
            </div>
            
            <div class="col-sm-12 d-flex align-items-center">
                <div class="trasaction-table table-responsive w-100">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Service Period</th>
                            <th>Payment Method</th>
                            <th class="text-end">Total</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>20/05/23</td>
                                <td>20/07/23 - 20/07/24</td>
                                <td><img src="{{ asset('/img/visa.svg') }}" alt="icon" class="me-2">visa **** **** **** 1823</td>
                                <td class="text-end">₹499</td>
                            </tr>
                        <tr>
                            <td>20/05/23</td>
                            <td>20/07/23 - 20/07/24</td>
                            <td><img src="{{ asset('/img/visa.svg') }}" alt="icon" class="me-2">visa **** **** **** 1823</td>
                            <td class="text-end">₹499</td>
                        </tr>
                        <tr>
                            <td>20/05/23</td>
                            <td>20/07/23 - 20/07/24</td>
                            <td><img src="{{ asset('/img/visa.svg') }}" alt="icon" class="me-2">visa **** **** **** 1823</td>
                            <td class="text-end">₹499</td>
                        </tr>
                        <tr>
                            <td>20/05/23</td>
                            <td>20/07/23 - 20/07/24</td>
                            <td><img src="{{ asset('/img/visa.svg') }}" alt="icon" class="me-2">visa **** **** **** 1823</td>
                            <td class="text-end">₹499</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    
@stop

@section('script')


@stop