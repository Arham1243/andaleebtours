@extends('admin.layouts.main')
@section('content')
    <div class="col-md-12">
        <div class="dashboard-content">
            {{ Breadcrumbs::render('admin.packages.edit', $package) }}
            <div class="custom-sec custom-sec--form">
                <div class="custom-sec__header">
                    <div class="section-content">
                        <h3 class="heading">{{ isset($title) ? $title : '' }}</h3>
                    </div>
                </div>
            </div>
            <form action="{{ route('admin.packages.update', $package->id) }}" method="POST" enctype="multipart/form-data"
                id="validation-form">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-wrapper">
                            <div class="form-box">
                                <div class="form-box__header">
                                    <div class="title">Package Details</div>
                                </div>
                                <div class="form-box__body">
                                    <div class="form-fields">
                                        <label class="title">Category <span class="text-danger">*</span></label>
                                        <select name="package_category_id" class="field select2-select"
                                            data-error="Category" data-required>
                                            <option value="" selected disabled>Select Category</option>
                                            @foreach ($categories as $id => $name)
                                                <option value="{{ $id }}"
                                                    {{ old('package_category_id', $package->package_category_id) == $id ? 'selected' : '' }}>
                                                    {{ $name }}</option>
                                            @endforeach
                                        </select>
                                        @error('package_category_id')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-fields">
                                        <label class="title">Package Name <span class="text-danger">*</span></label>
                                        <input type="text" name="name" id="package-name" class="field"
                                            value="{{ old('name', $package->name) }}" placeholder="Enter Package Name"
                                            required>
                                        @error('name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-fields">
                                        <label class="title">Slug </label>
                                        <input type="text" name="slug" id="package-slug" class="field"
                                            value="{{ old('slug', $package->slug) }}">
                                        <small class="text-muted">Leave empty to auto-generate</small>
                                        @error('slug')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="form-fields">
                                        <label class="title">Days</label>
                                        <input type="number" step="0.01" name="days" class="field"
                                            value="{{ old('days',$package->days ) }}" >
                                        @error('days')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    
                                    <div class="form-fields">
                                        <label class="title">Nights</label>
                                        <input type="number" step="0.01" name="nights" class="field"
                                            value="{{ old('nights', $package->nights) }}">
                                        @error('nights')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="form-fields">
                                        <label class="title">Price</label>
                                        <input type="number" step="0.01" name="price" class="field"
                                            value="{{ old('price', $package->price) }}" placeholder="Enter Price">
                                        @error('price')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-fields">
                                        <label class="title">Short Description</label>
                                        <textarea name="short_description" class="field" rows="4" placeholder="Enter Short Description">{{ old('short_description', $package->short_description) }}</textarea>
                                        @error('short_description')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-fields">
                                        <label class="title">Overview <span class="text-danger">*</span></label>
                                        <textarea class="editor" name="overview" data-placeholder="Overview" data-error="Overview" data-required>{{ old('overview', $package->content['overview'] ?? '') }}</textarea>
                                        @error('overview')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-fields">
                                        <label class="title">Package Details <span class="text-danger">*</span></label>
                                        <textarea class="editor" name="package_details" data-placeholder="Package Details" data-error="Package Details"
                                            data-required>{{ old('package_details', $package->content['package_details'] ?? '') }}</textarea>
                                        @error('package_details')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-fields">
                                        <label class="title">Itinerary <span class="text-danger">*</span></label>
                                        <textarea class="editor" name="itinerary" data-placeholder="Itinerary" data-error="Itinerary" data-required>{{ old('itinerary', $package->content['itinerary'] ?? '') }}</textarea>
                                        @error('itinerary')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-fields">
                                        <label class="title">Inclusion <span class="text-danger">*</span></label>
                                        <textarea class="editor" name="inclusion" data-placeholder="Inclusion" data-error="Inclusion" data-required>{{ old('inclusion', $package->content['inclusion'] ?? '') }}</textarea>
                                        @error('inclusion')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-fields">
                                        <label class="title">Exclusion <span class="text-danger">*</span></label>
                                        <textarea class="editor" name="exclusion" data-placeholder="Exclusion" data-error="Exclusion" data-required>{{ old('exclusion', $package->content['exclusion'] ?? '') }}</textarea>
                                        @error('exclusion')
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
                                            {{ old('status', $package->status) == 'active' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="active">
                                            Active
                                        </label>
                                    </div>
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="radio" name="status" id="inactive"
                                            value="inactive"
                                            {{ old('status', $package->status) == 'inactive' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="inactive">
                                            Inactive
                                        </label>
                                    </div>

                                    <div class="form-check form-switch mt-4">
                                        <input class="form-check-input" type="checkbox" name="is_featured"
                                            id="is_featured" value="1"
                                            {{ old('is_featured', $package->is_featured) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_featured">Is Featured</label>
                                    </div>

                                    <div class="text-end mt-4">
                                        <button class="themeBtn" type="submit">Update Package</button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-box">
                                <div class="form-box__header">
                                    <div class="title">Image</div>
                                </div>
                                <div class="form-box__body">
                                    <x-admin.image-upload name="image" label="Package Image" :existing-image="$package->image" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nameInput = document.getElementById('package-name');
            const slugInput = document.getElementById('package-slug');
            let manualSlugEdit = false;

            function generateSlug(text) {
                return text
                    .toLowerCase()
                    .trim()
                    .replace(/[^\w\s-]/g, '')
                    .replace(/[\s_-]+/g, '-')
                    .replace(/^-+|-+$/g, '');
            }

            nameInput.addEventListener('input', function() {
                if (!manualSlugEdit && !slugInput.value) {
                    slugInput.value = generateSlug(this.value);
                }
            });

            slugInput.addEventListener('input', function() {
                manualSlugEdit = true;
            });

            slugInput.addEventListener('blur', function() {
                if (!this.value.trim()) {
                    manualSlugEdit = false;
                    this.value = generateSlug(nameInput.value);
                }
            });
        });
    </script>
@endpush
