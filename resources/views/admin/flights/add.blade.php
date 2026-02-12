@extends('admin.layouts.main')
@section('content')
    <div class="col-md-12">
        <div class="dashboard-content">
            {{ Breadcrumbs::render('admin.flights.create') }}
            <form action="{{ route('admin.flights.store') }}" method="POST" enctype="multipart/form-data"
                id="validation-form">
                @csrf
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-wrapper">
                            <div class="form-box">
                                <div class="form-box__header">
                                    <div class="title">Flight Details</div>
                                </div>
                                <div class="form-box__body">
                                    <div class="form-fields">
                                        <label class="title">Destination Name <span class="text-danger">*</span></label>
                                        <input type="text" name="destination_name" class="field"
                                            value="{{ old('destination_name') }}" placeholder="e.g., London" required>
                                        @error('destination_name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-fields">
                                                <label class="title">Origin Code <span class="text-danger">*</span></label>
                                                <input type="text" name="origin_code" class="field"
                                                    value="{{ old('origin_code', 'DXB') }}" placeholder="e.g., DXB" required>
                                                @error('origin_code')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-fields">
                                                <label class="title">Destination Code <span class="text-danger">*</span></label>
                                                <input type="text" name="destination_code" class="field"
                                                    value="{{ old('destination_code') }}" placeholder="e.g., LHR" required>
                                                @error('destination_code')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-fields">
                                                <label class="title">Price (AED) <span class="text-danger">*</span></label>
                                                <input type="number" name="price" class="field" step="0.01"
                                                    value="{{ old('price') }}" placeholder="e.g., 1850" required>
                                                @error('price')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-fields">
                                                <label class="title">Class <span class="text-danger">*</span></label>
                                                <select name="class" class="field" required>
                                                    <option value="Economy" {{ old('class') == 'Economy' ? 'selected' : '' }}>Economy</option>
                                                    <option value="Business" {{ old('class') == 'Business' ? 'selected' : '' }}>Business</option>
                                                    <option value="First Class" {{ old('class') == 'First Class' ? 'selected' : '' }}>First Class</option>
                                                </select>
                                                @error('class')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-fields">
                                                <label class="title">Departure Date</label>
                                                <input type="text" name="departure_date" class="field"
                                                    value="{{ old('departure_date') }}" placeholder="e.g., 20 Oct">
                                                @error('departure_date')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-fields">
                                                <label class="title">Duration</label>
                                                <input type="text" name="duration" class="field"
                                                    value="{{ old('duration') }}" placeholder="e.g., 7h 10m">
                                                @error('duration')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-fields">
                                        <label class="title">Badge</label>
                                        <input type="text" name="badge" class="field"
                                            value="{{ old('badge') }}" placeholder="e.g., Trending, Best Deal">
                                        <small class="text-muted">Optional badge text to display on the card</small>
                                        @error('badge')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="seo-wrapper">

                            <div class="form-box">
                                <div class="form-box__header">
                                    <div class="title">Status</div>
                                </div>
                                <div class="form-box__body">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" id="active"
                                            value="active" {{ old('status', 'active') == 'active' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="active">
                                            Active
                                        </label>
                                    </div>
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="radio" name="status" id="inactive"
                                            value="inactive" {{ old('status') == 'inactive' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="inactive">
                                            Inactive
                                        </label>
                                    </div>

                                    <div class="form-check form-switch mt-4">
                                        <input class="form-check-input" type="checkbox" name="is_featured"
                                            id="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_featured">Is Featured</label>
                                    </div>
                                    <div class="text-end mt-3">
                                        <button class="themeBtn" type="submit">Add Flight</button>
                                    </div>
                                </div>
                            </div>

                            <div class="form-box">
                                <div class="form-box__header">
                                    <div class="title">Image</div>
                                </div>
                                <div class="form-box__body">
                                    <x-admin.image-upload name="image" label="Flight Image" :required="true" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
