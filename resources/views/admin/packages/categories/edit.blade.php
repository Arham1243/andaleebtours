@extends('admin.layouts.main')
@section('content')
    <div class="col-md-12">
        <div class="dashboard-content">
            {{ Breadcrumbs::render('admin.package-categories.edit', $packageCategory) }}
            <div class="custom-sec custom-sec--form">
                <div class="custom-sec__header">
                    <div class="section-content">
                        <h3 class="heading">{{ isset($title) ? $title : '' }}</h3>
                    </div>
                </div>
            </div>
            <form action="{{ route('admin.package-categories.update', $packageCategory->id) }}" method="POST"
                enctype="multipart/form-data" id="validation-form">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-wrapper">
                            <div class="form-box">
                                <div class="form-box__header">
                                    <div class="title">Category Details</div>
                                </div>
                                <div class="form-box__body">
                                    <div class="form-fields">
                                        <label class="title">Category Name <span class="text-danger">*</span></label>
                                        <input type="text" name="name" class="field"
                                            value="{{ old('name', $packageCategory->name) }}"
                                            placeholder="Enter Category Name" required>
                                        @error('name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-fields">
                                        <label class="title">Short Description</label>
                                        <textarea name="short_description" class="field" rows="4" placeholder="Enter Short Description">{{ old('short_description', $packageCategory->short_description) }}</textarea>
                                        @error('short_description')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-4">
                                            <x-admin.image-upload name="image" label="Category Image" :existing-image="$packageCategory->image" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="seo-wrapper">
                            <div class="form-box">
                                <div class="form-box__header">
                                    <div class="title">Featured</div>
                                </div>
                                <div class="form-box__body">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured"
                                            value="1"
                                            {{ old('is_featured', $packageCategory->is_featured) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_featured">
                                            Mark as Featured
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-box">
                                <div class="form-box__header">
                                    <div class="title">Status</div>
                                </div>
                                <div class="form-box__body">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" id="active"
                                            value="active"
                                            {{ old('status', $packageCategory->status) == 'active' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="active">
                                            Active
                                        </label>
                                    </div>
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="radio" name="status" id="inactive"
                                            value="inactive"
                                            {{ old('status', $packageCategory->status) == 'inactive' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="inactive">
                                            Inactive
                                        </label>
                                    </div>
                                    <div class="text-end mt-3">
                                        <button class="themeBtn" type="submit">Update Category</button>
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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const nameInput = document.getElementById('category-name');
        const slugInput = document.getElementById('category-slug');
        let manualSlugEdit = false;

        // Function to generate slug from text
        function generateSlug(text) {
            return text
                .toLowerCase()
                .trim()
                .replace(/[^\w\s-]/g, '')
                .replace(/[\s_-]+/g, '-')
                .replace(/^-+|-+$/g, '');
        }

        // Auto-generate slug when name changes (only if user hasn't manually edited slug)
        nameInput.addEventListener('input', function() {
            if (!manualSlugEdit && !slugInput.value) {
                slugInput.value = generateSlug(this.value);
            }
        });

        // Mark that user has manually edited the slug
        slugInput.addEventListener('input', function() {
            manualSlugEdit = true;
        });

        // If slug is cleared, allow auto-generation again
        slugInput.addEventListener('blur', function() {
            if (!this.value.trim()) {
                manualSlugEdit = false;
                this.value = generateSlug(nameInput.value);
            }
        });
    });
</script>
@endpush
