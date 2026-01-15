@extends('admin.layouts.main')
@section('content')
    <div class="col-md-12">
        <div class="dashboard-content">
            {{ Breadcrumbs::render('admin.hotels.create') }}
            <form action="{{ route('admin.hotels.store') }}" method="POST" enctype="multipart/form-data" id="validation-form">
                @csrf
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-wrapper">
                            <div class="form-box">
                                <div class="form-box__header">
                                    <div class="title">
                                        Hotel Details
                                    </div>
                                </div>
                                <div class="form-box__body">
                                    <div class="form-fields">
                                        <label class="title">Yalago ID <span class="text-danger">*</span></label>
                                        <input type="text" name="yalago_id" class="field" value="{{ old('yalago_id') }}"
                                            data-required data-error="Yalago ID">
                                        @error('yalago_id')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-fields">
                                        <label class="title">Name <span class="text-danger">*</span></label>
                                        <input type="text" name="name" class="field" value="{{ old('name') }}"
                                            data-required data-error="Name">
                                        @error('name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-fields">
                                        <label class="title">Country <span class="text-danger">*</span></label>
                                        <select name="country_id" class="field select2-select" data-error="Country"
                                            data-required>
                                            <option value="" selected disabled>Select Country</option>
                                            @foreach ($countries as $c)
                                                <option value="{{ $c->id }}"
                                                    {{ old('country_id') == $c->id ? 'selected' : '' }}>
                                                    {{ $c->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('country_id')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-fields">
                                        <label class="title">Province <span class="text-danger">*</span></label>
                                        <select name="province_id" class="field select2-select" data-error="Province"
                                            data-required>
                                            <option value="" selected disabled>Select Province</option>
                                            @foreach ($provinces as $p)
                                                <option value="{{ $p->id }}"
                                                    {{ old('province_id') == $p->id ? 'selected' : '' }}>
                                                    {{ $p->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('province_id')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-fields">
                                        <label class="title">Location <span class="text-danger">*</span></label>
                                        <select name="location_id" class="field select2-select" data-error="Location"
                                            data-required>
                                            <option value="" selected disabled>Select Location</option>
                                            @foreach ($locations as $l)
                                                <option value="{{ $l->id }}"
                                                    {{ old('location_id') == $l->id ? 'selected' : '' }}>
                                                    {{ $l->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('location_id')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-fields">
                                        <label class="title">Rating</label>
                                        <input type="number" name="rating" class="field" value="{{ old('rating') }}"
                                            step="0.1" min="0" max="5">
                                        @error('rating')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-fields">
                                        <label class="title">Address</label>
                                        <textarea name="address" class="field">{{ old('address') }}</textarea>
                                        @error('address')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-fields">
                                        <label class="title">Postal Code</label>
                                        <input type="text" name="postal_code" class="field"
                                            value="{{ old('postal_code') }}">
                                        @error('postal_code')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-fields">
                                        <label class="title">Phone</label>
                                        <input type="text" name="phone" class="field" value="{{ old('phone') }}">
                                        @error('phone')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-fields">
                                        <label class="title">Email</label>
                                        <input type="email" name="email" class="field" value="{{ old('email') }}">
                                        @error('email')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-fields">
                                        <label class="title">Longitude</label>
                                        <input type="text" name="longitude" class="field"
                                            value="{{ old('longitude') }}">
                                        @error('longitude')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-fields">
                                        <label class="title">Latitude</label>
                                        <input type="text" name="latitude" class="field"
                                            value="{{ old('latitude') }}">
                                        @error('latitude')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-fields">
                                        <label class="title">Geo Code Accuracy</label>
                                        <input type="text" name="geo_code_accuracy" class="field"
                                            value="{{ old('geo_code_accuracy') }}">
                                        @error('geo_code_accuracy')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-fields">
                                        <label class="title">Description</label>
                                        <textarea rows="5" name="description" class="field">{{ old('description') }}</textarea>
                                        @error('description')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-fields">
                                        <label class="title">Summary</label>
                                        <textarea rows="5" name="summary" class="field">{{ old('summary') }}</textarea>
                                        @error('summary')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-fields">
                                        <label class="title">Images (JSON)</label>
                                        <textarea rows="5" name="images" class="field">{{ old('images') }}</textarea>
                                        @error('images')
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
                                    {{-- <div class="form-check form-switch mt-4">
                                        <input class="form-check-input" type="checkbox" name="is_featured"
                                            id="is_featured" value="1"
                                            {{ old('is_featured') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_featured">Is Featured</label>
                                    </div> --}}

                                    <div class="text-end mt-3">
                                        <button class="themeBtn" type="submit">Add</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
