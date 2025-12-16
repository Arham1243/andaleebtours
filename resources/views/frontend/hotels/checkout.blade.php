@extends('frontend.layouts.main')
@section('content')
    <div class="py-2">
        <div class="container">
            <nav class="breadcrumb-nav">
                <ul class="breadcrumb-list">

                    <li class="breadcrumb-item">
                        <a href="{{ route('frontend.index') }}" class="breadcrumb-link">Home</a>
                        <i class='bx bx-chevron-right breadcrumb-separator'></i>
                    </li>


                    <li class="breadcrumb-item">
                        <a href="{{ route('frontend.hotels.index') }}" class="breadcrumb-link">Hotels</a>
                        <i class='bx bx-chevron-right breadcrumb-separator'></i>
                    </li>

                    <li class="breadcrumb-item">
                        <a href="{{ route('frontend.hotels.details') }}" class="breadcrumb-link">Le Meridien Dubai Hotel &
                            Conference Centre</a>
                        <i class='bx bx-chevron-right breadcrumb-separator'></i>
                    </li>

                    <li class="breadcrumb-item active">
                        Guest info
                    </li>
                </ul>
            </nav>
        </div>
    </div>
@endsection
@push('js')
@endpush
