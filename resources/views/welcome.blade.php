@extends('AdminPanel.app')
@section('content')
    <div class="row mt-5" >
        {{-- <div class="col-4 bg-secondary  mr-5">
            <h1>{{ __('lang.admins') }}</h1>
            <span>{{\App\Models\Admin::count()}}</span>
        </div> --}}
        <div class="col-4 bg-secondary ">
            <h1>{{ __('lang.users') }}</h1>
            <span>{{\App\Models\User::count()}}</span>
        </div>
    </div>

    <div class="row mt-5 h-25">
        <div class="col-4 bg-secondary   mr-5">
            <h1>{{ __('lang.trips') }}</h1>
            {{-- <span>{{\App\Models\Trip::count()}}</span> --}}
        </div>

        <div class="col-4 bg-secondary  ">
            <h1>{{ __('lang.offers') }}</h1>
            {{-- <span>{{\App\Models\Offer::count()}}</span> --}}
        </div>
    </div>

    <div class="row mt-5 ">
        <div class="col-4 bg-secondary   mr-5">
            <h1>{{ __('lang.cruises') }}</h1>
            {{-- <span>{{\App\Models\Cruise::count()}}</span> --}}
        </div>

        <div class="col-4 bg-secondary ">
            <h1>{{ __('lang.capines') }}</h1>
            {{-- <span>{{\App\Models\Capine::count()}}</span> --}}
        </div>
    </div>
@endsection
