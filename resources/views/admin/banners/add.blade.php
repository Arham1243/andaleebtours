@extends('admin.layouts.main')
@section('content')
    <div class="col-md-12">
        <div class="dashboard-content">
            {{ Breadcrumbs::render('admin.banners.create') }}
            <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data"
                id="validation-form">
                @csrf
                <div class="row">
                    <div class="col-md-9">
                        <div class="form-wrapper">
                            <div class="form-box">
                                <div class="form-box__header">
                                    <div class="title">Banner Details</div>
                                </div>
                                <div class="form-box__body">
                                    <div class="form-fields">
                                        <label class="title">Select Page <span class="text-danger">*</span></label>
                                        <select name="page" class="field select2-select" data-error="Page" required>
                                            <option value="" selected disabled>Select Page</option>
                                            @foreach($pages as $key => $page)
                                                <option value="{{ $key }}" {{ old('page') == $key ? 'selected' : '' }}>{{ $page }}</option>
                                            @endforeach
                                        </select>
                                        @error('page')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-fields">
                                        <label class="title">Heading </label>
                                        <input type="text" name="heading" class="field"
                                            value="{{ old('heading') }}" placeholder="Enter Banner Heading">
                                        @error('heading')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-fields">
                                        <label class="title">Paragraph </label>
                                        <textarea name="paragraph" class="field" rows="4"
                                            placeholder="Enter Banner Paragraph">{{ old('paragraph') }}</textarea>
                                        @error('paragraph')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <x-admin.image-upload 
                                        name="image" 
                                        label="Banner Image" 
                                        :required="true" 
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="seo-wrapper">
                            <div class="form-box">
                                <div class="form-box__header">
                                    <div class="title">Status</div>
                                </div>
                                <div class="form-box__body">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" id="active"
                                            value="active"
                                            {{ old('status', 'active') == 'active' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="active">
                                            Active
                                        </label>
                                    </div>
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="radio" name="status" id="inactive"
                                            value="inactive"
                                            {{ old('status') == 'inactive' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="inactive">
                                            Inactive
                                        </label>
                                    </div>
                                    <button class="themeBtn ms-auto mt-4">Add Banner</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
