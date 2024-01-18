@extends('layouts.default')
@section('title', 'Manage Profile')
 

@section('content')

    <section class="w-100 mt-5">
        <h4 class="w-100 text-white text-center">{{__('Manage Profiles')}}</h4>
        @if ($data['profiles'])
            <div class="manage-profile">
                <ul class="list-unstyled m-0 p-0">
                    @foreach ($data['profiles'] as $key => $value)
                        <?php
                        
                        $gender = @$data['result']['user_data']['gender'] ?? 'Male';
                        $default_img = $gender == 'Female' ? asset('assets/img/edit-profile-pik.png') : asset('assets/img/profile-boy.png');
                        
                        $profile_img = trim(@$value['profile_img']) != '' ? @$value['profile_img'] : $default_img;
                        ?>
                        <li>
                            <a href="{{ getUrlWithPrefix('profile.edit', $value['id']) }}">
                                <img src="{{ $profile_img }}" alt="img">
                                <span><img src="{{ asset('assets/img/mn-edit-icon.png') }}" alt="icon"></span>
                            </a>
                            <p class="mt-2">{{ ucfirst(@$value['name']) }}</p>
                        </li>
                    @endforeach

                    @if (count($data['profiles']) < $data['profile_limit'])
                        <li>
                            <a href="{{ getUrlWithPrefix('profile.add') }}">
                                <img src="{{ asset('assets/img/mn-add.png') }}" alt="img">
                            </a>
                            <p class="mt-2">Add</p>
                        </li>
                    @endif
                </ul>
                {{-- <button class="custom-btn mt-4">{{__('Done')}}</button> --}}
            </div>
        @else
            <!-- <h2>{{__('No data found')}}</h2> -->
            <h6 class="mt-4" style="color:white;">No Data Found</h6>
        @endif

    </section>



@stop

@section('script')

@stop
