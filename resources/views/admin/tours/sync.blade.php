@extends('admin.layouts.main')
@section('content')
    <div class="col-md-12">
        <div class="dashboard-content">
            {{ Breadcrumbs::render('admin.tours.sync') }}
            <form action="{{ route('admin.tours.sync.update') }}" method="POST" enctype="multipart/form-data"
                id="validation-form">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-wrapper">
                            <div class="form-box">
                                <div class="form-box__header">
                                    <div class="title">Prio Ticket's Tours</div>
                                </div>
                                <div class="form-box__body">
                                    <div class="form-fields">
                                        <label class="title">Select Page <span class="text-danger">*</span></label>
                                        <select name="page" class="field select2-select" data-error="Page">
                                            <option value="" selected disabled>Select Page</option>
                                            @for ($i = 1; $i <= 3; $i++)
                                                <option value="{{ $i }}" {{ $i === 1 ? 'selected' : '' }}>
                                                    {{ $i }}
                                                </option>
                                            @endfor
                                        </select>
                                        @error('page')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <button    onclick="return confirm('Are you sure you want to sync all tours?');" class="themeBtn ms-auto mt-4">Sync Tours</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
