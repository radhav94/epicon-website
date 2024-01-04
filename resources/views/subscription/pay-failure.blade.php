@extends('layouts.default')
@section('title','Subscription fail')
@section('content')

<style>
      html{
        width: 100%;
        height: 100%;
      }
      body{
        width: 100%;
        height: 100%;
        box-sizing: border-box;
        margin: 0;
        padding: 0;
      }
      .main-header,.footer{
        display: none;
      }
      .payu-success{
        width: 100%;
        height: 100%;
        background-image: url("payu-success-bg.jpg");
        background-position: center center;
        background-repeat: no-repeat;
        background-size: cover;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
      }
      .payu-failler-bg{
        background-image: url("payu-failler-bg.jpg");
      }
      .epicon-logo-footer-right{
        position: absolute;
        right: 0;
        bottom: -5px;
        width: 400px;
        height: auto;
        z-index: 1;
      }
      .epicon-logo-footer-right img{
        width: 100%;
        height: 100%;
      }
      .payu-card{
        border-radius: 30px;
        opacity: 0.8;
        background: rgba(196, 196, 196, 0.01);
        box-shadow: 0px 0.85px 34px 0px rgba(227, 222, 255, 0.20) inset, 0px 3.4px 15.3px 0px rgba(154, 146, 210, 0.30) inset, 0px 83.3px 85px -40.8px rgba(202, 172, 255, 0.30) inset, 0px -69.7px 57.8px -54.4px rgba(96, 68, 144, 0.30) inset, 0px 5.95px 9.35px -3.4px #FFF inset, 0px 33.15px 47.6px -30.6px rgba(255, 255, 255, 0.50) inset;
        backdrop-filter: blur(42.500003814697266px);
        padding: 40px 80px;
        width: fit-content;
        height: auto;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        animation: rubberBand 1s linear 1;
        animation-delay: 0.3s;
        visibility: hidden;
        animation-fill-mode: both;
      }
      @keyframes rubberBand {
        from {
          transform: scale3d(1, 1, 1);
          visibility: visible;
        }

        30% {
          transform: scale3d(1.25, 0.75, 1);
          visibility: visible;
        }

        40% {
          transform: scale3d(0.75, 1.25, 1);
          visibility: visible;
        }

        50% {
          transform: scale3d(1.15, 0.85, 1);
          visibility: visible;
        }

        65% {
          transform: scale3d(.95, 1.05, 1);
          visibility: visible;
        }

        75% {
          transform: scale3d(1.05, .95, 1);
          visibility: visible;
        }

        to {
          transform: scale3d(1, 1, 1);
          visibility: visible;
        }
      }
      .payu-card img{
        height: 80px;
        margin-bottom: 10px;
      }
      .payu-card h1,.payu-card p{
        color: #FFF;
        font-size: 46px;
        font-style: normal;
        font-weight: 700;
        margin-block-start: 10px;
        margin-block-end: 0px;
        animation: bottommoving 1s linear 1;
        animation-delay: 0.3s;
        visibility: hidden;
        animation-fill-mode: both;
      }
      @keyframes bottommoving {
        0%{
          translate: translateY(-100px);
          visibility: visible;
        }
        100%{
          translate: translateY(0);
          visibility: visible;
        }
      }
      .payu-card p{
        font-weight: 600;
        font-size: 20px;
        margin-block-end: 0;
      }
      .elfr-opacity{
        opacity: 0.5;
      }

      @media (max-width:768px) {
        .payu-card h1{
          font-size: 30px;
        }
        .payu-card p{
          font-size: 16px;
          margin-block-end: 0;
        }
        .epicon-logo-footer-right{
          width: 220px;
        }
        .payu-card{
          padding: 20px 20px;
          margin-bottom: 145px;
          width:50%;
        }
        .payu-card img{
          height: 60px;
        }
        .footer-mobile {
            display: none;
        }
      }
      @media (max-width:767px) {
        .payu-card{
          width:90%;
        }
      }
    </style>

<section class="payu-success payu-failler-bg">
      <div class="payu-card">
        <img src="{{ asset('assets/img/failer-icon-payu.svg')}}" alt="icon">
        <h1>Oh No!</h1>
        <p>Something went wrong</p>
      </div>
      <div class="epicon-logo-footer-right elfr-opacity">
        <img src="{{ asset('assets/img/epicon-logo-footer-right.svg')}}" alt="icon">
      </div>
</section>


@stop

