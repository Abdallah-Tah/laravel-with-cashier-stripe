@extends('layouts.master')

@section('tab_tittle', 'Plans')

@section('content')
    <link rel="stylesheet" href="{{ asset('assets/css/plan-selection.css') }}">


    <div class="container">
        <div class="row mt-5 mb-5 justify-content-center">
            @foreach ($plans as $item)
                <div class="col-sm text-center">
                    <div class="card mb-4 rounded-3 shadow-sm {{ strtolower($item->name) }}-highlight">
                        @if ($item->name == 'Deluxe')
                            <p class="plan-recommended">{{ __('Recommended') }}</p>
                        @endif
                        <div class="card-body">
                            <h1 class="my-0 fw-normal mt-3 {{ strtolower($item->name) }}">{{ $item->name }}</h1>
                            <br>
                            <h4 class="card-title pricing-card-title">
                                ${{ number_format($item->price / 100, 2) }}<small class="text-muted fw-light">/mo</small>
                            </h4>
                            <ul class="list-unstyled my-3">
                                @foreach ($item->features as $feature)
                                    <li>
                                        <p>{{ $feature->name }}</p>
                                    </li>
                                @endforeach
                            </ul>
                            <a href="{{ route('plans.show', $item->slug) }}" 
                                class="btn btn-{{ strtolower($item->name) }} subscribe-btn">{{ __('Subscribe') }}</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
