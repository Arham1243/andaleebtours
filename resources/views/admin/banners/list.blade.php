@extends('admin.layouts.main')
@section('content')
    <div class="col-md-12">
        <div class="dashboard-content">
            {{ Breadcrumbs::render('admin.banners.index') }}
            <form id="bulkActionForm" method="POST" action="{{ route('admin.bulk-actions', ['resource' => 'banners']) }}">
                @csrf
                <div class="table-container universal-table">
                    <div class="custom-sec">
                        <div class="custom-sec__header">
                            <div class="section-content">
                                <h3 class="heading">{{ isset($title) ? $title : '' }}</h3>
                            </div>
                            <a href="{{ route('admin.banners.create') }}" class="themeBtn">Add New Banner</a>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-5">
                                <form class="custom-form ">
                                    <div class="form-fields d-flex gap-3">
                                        <select class="field" id="bulkActions" name="bulk_actions" required>
                                            <option value="" disabled selected>Bulk Actions</option>
                                            <option value="active">Make Active</option>
                                            <option value="inactive">Make Inactive</option>
                                            <option value="delete">Delete</option>
                                        </select>
                                        <button type="submit" onclick="confirmBulkAction(event)"
                                            class="themeBtn">Apply</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th class="no-sort">
                                            <div class="selection select-all-container"><input type="checkbox"
                                                    id="select-all">
                                            </div>
                                        </th>
                                        <th>Page</th>
                                        <th>Image</th>
                                        <th>Heading</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($banners as $banner)
                                        <tr>
                                            <td>
                                                <div class="selection item-select-container"><input type="checkbox"
                                                        class="bulk-item" name="bulk_select[]" value="{{ $banner->id }}">
                                                </div>
                                            </td>
                                            <td>{{ ucwords(str_replace('-', ' ', $banner->page)) }}</td>
                                            <td>
                                                @if ($banner->image)
                                                    <a href="{{ asset($banner->image) }}" data-fancybox="image">
                                                        <img src="{{ asset($banner->image) }}" alt="Banner"
                                                            style="width: 80px; height: 50px; object-fit: contain;">
                                                    </a>
                                                @else
                                                    <span class="text-muted">No Image</span>
                                                @endif
                                            </td>
                                            <td>{{ $banner->heading ?? 'N/A' }}</td>
                                            <td>
                                                <span
                                                    class="badge rounded-pill bg-{{ $banner->status === 'active' ? 'success' : 'danger' }}">
                                                    {{ ucfirst($banner->status) }}</span>
                                            </td>
                                            <td>{{ formatDateTime($banner->created_at) }}</td>
                                            <td>
                                                <div class="dropstart">
                                                    <button type="button" class="recent-act__icon dropdown-toggle"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class='bx bx-dots-vertical-rounded'></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="{{ route('admin.banners.edit', $banner->id) }}">
                                                                <i class="bx bx-edit"></i>
                                                                Edit
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="{{ route('admin.banners.change-status', $banner->id) }}">
                                                                <i
                                                                    class="bx {{ $banner->status === 'active' ? 'bx-x' : 'bx-check' }}"></i>
                                                                {{ $banner->status === 'active' ? 'Make Inactive' : 'Make Active' }}
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <form
                                                                action="{{ route('admin.banners.destroy', $banner->id) }}"
                                                                method="POST"
                                                                onsubmit="return confirm('Are you sure you want to delete?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="dropdown-item">
                                                                    <i class="bx bx-trash"></i>
                                                                    Delete
                                                                </button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
