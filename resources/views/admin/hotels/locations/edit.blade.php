@extends('admin.layouts.main')
@section('content')
    <div class="col-md-12">
        <div class="dashboard-content">
            {{ Breadcrumbs::render('admin.locations.create') }}
            <form action="{{ route('admin.locations.update', $location->id) }}" method="POST" enctype="multipart/form-data"
                id="validation-form">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-wrapper">
                            <div class="form-box">
                                <div class="form-box__header">
                                    <div class="title">Location Details</div>
                                </div>
                                <div class="form-box__body">
                                    <div class="form-fields">
                                        <label class="title">Yalago ID <span class="text-danger">*</span></label>
                                        <input type="text" name="yalago_id" class="field"
                                            value="{{ old('yalago_id', $location->yalago_id) }}" data-required
                                            data-error="Yalago ID">
                                        @error('yalago_id')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-fields">
                                        <label class="title">Name <span class="text-danger">*</span></label>
                                        <input type="text" name="name" class="field"
                                            value="{{ old('name', $location->name) }}" data-required data-error="Name">
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
                                                    {{ old('country_id', $location->country_id) == $c->id ? 'selected' : '' }}>
                                                    {{ $c->name }}</option>
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
                                                    {{ old('province_id', $location->province_id) == $p->id ? 'selected' : '' }}>
                                                    {{ $p->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('province_id')
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
                                            value="active"
                                            {{ old('status', $location->status) == 'active' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="active">
                                            Active
                                        </label>
                                    </div>
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="radio" name="status" id="inactive"
                                            value="inactive"
                                            {{ old('status', $location->status) == 'inactive' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="inactive">
                                            Inactive
                                        </label>
                                    </div>
                                    <div class="text-end mt-3">
                                        <button class="themeBtn" type="submit">Save Changes</button>
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
