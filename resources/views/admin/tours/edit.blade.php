@extends('admin.layouts.main')
@section('content')
    <div class="col-md-12">
        <div class="dashboard-content">
            {{ Breadcrumbs::render('admin.tours.edit', $tour) }}
            <form action="{{ route('admin.tours.update', $tour->id) }}" method="POST" enctype="multipart/form-data" id="validation-form">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-9">
                        <div class="form-wrapper">
                            <div class="form-box">
                                <div class="form-box__header">
                                    <div class="title">Tour Details</div>
                                </div>
                                <div class="form-box__body">
                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-fields">
                                                <label class="title">Distributer</label>
                                                <input type="text" name="distributer_name" class="field"
                                                    value="{{ old('distributer_name', $tour->distributer_name) }}">
                                                @error('distributer_name')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-fields">
                                                <label class="title">Tour Type</label>
                                                <input type="text" name="type" class="field"
                                                    value="{{ old('type', $tour->type) }}">
                                                @error('type')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6 mt-4">
                                            <div class="form-fields">
                                                <label class="title required">Name</label>
                                                <input type="text" name="name" class="field"
                                                    value="{{ old('name', $tour->name) }}" data-required data-error="Name">
                                                @error('name')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6 mt-4">
                                            <div class="form-fields">
                                                <label class="title">Slug </label>
                                                <input type="text" name="slug" id="category-slug" class="field"
                                                    value="{{ old('slug', $tour->slug) }}">
                                                <small class="text-muted">Leave empty to auto-generate</small>
                                                @error('slug')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6 mt-4">
                                            <div class="form-fields">
                                                <label class="title required">List Price</label>
                                                <input data-required data-error="List Price" type="number" step="0.01" name="discount_price" class="field"
                                                    value="{{ old('discount_price', $tour->discount_price) }}">
                                                @error('discount_price')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6 mt-4">
                                            <div class="form-fields">
                                                <label class="title required">Sell Price</label>
                                                <input data-required data-error="Sell Price" type="number" step="0.01" name="price" class="field"
                                                    value="{{ old('price', $tour->price) }}">
                                                @error('price')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6 mt-4">
                                            <div class="form-fields">
                                                <label class="title required">Duration</label>
                                                <input data-required data-error="Duration" type="text" name="duration" class="field"
                                                    value="{{ old('duration', $tour->duration) }}">
                                                @error('duration')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6 mt-4">
                                            <div class="form-fields">
                                                <label class="title required">Minimum Pax</label>
                                                <input data-required data-error="Minimum Pax" type="number" name="min_qty" class="field"
                                                    value="{{ old('min_qty', $tour->min_qty) }}">
                                                @error('min_qty')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6 mt-4">
                                            <div class="form-fields">
                                                <label class="title required">Maximum Pax</label>
                                                <input data-required data-error="Maximum Pax" type="number" name="max_qty" class="field"
                                                    value="{{ old('max_qty', $tour->max_qty) }}">
                                                @error('max_qty')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-12 mt-4">
                                            <div class="form-fields">
                                                <label class="title required">Short Description</label>
                                                <textarea data-required data-error="Short Description" name="short_description" class="field" rows="4">{{ old('short_description', $tour->short_description) }}</textarea>
                                                @error('short_description')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-12 mt-4">
                                            <div class="form-fields">
                                                <label class="title required">Long Description</label>
                                                <textarea data-required data-error="Long Description" name="long_description" class="field" rows="6">{{ old('long_description', $tour->long_description) }}</textarea>
                                                @error('long_description')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-12 mt-4">
                                            <div class="form-fields">
                                                <label class="title required">Additional Information</label>
                                                <textarea data-required data-error="Additional Information" name="additional_information" class="field" rows="4">{{ old('additional_information', $tour->additional_information) }}</textarea>
                                                @error('additional_information')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-12 mt-4">
                                            <div class="form-fields">
                                                <label class="title required">Cancellation Policies</label>
                                                <textarea data-required data-error="Cancellation Policies" name="cancellation_policies" class="field" rows="4">{{ old('cancellation_policies', $tour->cancellation_policies) }}</textarea>
                                                @error('cancellation_policies')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="seo-wrapper">
                            <div class="form-box">
                                <div class="form-box__header">
                                    <div class="title">Settings</div>
                                </div>
                                <div class="form-box__body">

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" id="active"
                                            value="active" {{ old('status', $tour->status) == 'active' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="active">Active</label>
                                    </div>

                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="radio" name="status" id="inactive"
                                            value="inactive" {{ old('status', $tour->status) == 'inactive' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="inactive">Inactive</label>
                                    </div>

                                    <div class="form-check form-switch mt-4">
                                        <input class="form-check-input" type="checkbox" name="is_featured"
                                            id="is_featured" value="1" {{ old('is_featured', $tour->is_featured) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_featured">Is Featured</label>
                                    </div>

                                    <div class="form-check form-switch mt-2">
                                        <input class="form-check-input" type="checkbox" name="is_recommended"
                                            id="is_recommended" value="1"
                                            {{ old('is_recommended', $tour->is_recommended) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_recommended">Is Recommended</label>
                                    </div>

                                    <button class="themeBtn ms-auto mt-4" type="submit">Save Changes</button>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
@endsection
