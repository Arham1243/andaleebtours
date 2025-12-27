@extends('admin.layouts.main')
@section('content')
    <div class="col-md-12">
        <div class="dashboard-content">
            {{ Breadcrumbs::render('admin.tours.index') }}
            <form id="bulkActionForm" method="POST" action="{{ route('admin.bulk-actions', ['resource' => 'tours']) }}">
                @csrf
                <div class="table-container universal-table">
                    <div class="custom-sec">
                        <div class="custom-sec__header">
                            <div class="section-content">
                                <h3 class="heading">{{ isset($title) ? $title : '' }}</h3>
                            </div>
                            <a href="{{ route('admin.tours.create') }}" class="themeBtn">Add New Tour</a>
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
                                            <div class="selection select-all-container">
                                                <input type="checkbox" id="select-all">
                                            </div>
                                        </th>
                                        <th>Tour Type</th>
                                        <th>Name</th>
                                        <th>List Price</th>
                                        <th>Sell Price</th>
                                        <th>Child Price</th>
                                        <th>Is Featured</th>
                                        <th>Is Recommended</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th>Updated At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tours as $tour)
                                        <tr>
                                            <td>
                                                <div class="selection item-select-container">
                                                    <input type="checkbox" class="bulk-item" name="bulk_select[]"
                                                        value="{{ $tour->id }}">
                                                </div>
                                            </td>
                                            <td>{{ $tour->type ?? 'N/A' }}</td>
                                            <td>{{ $tour->name ?? 'N/A' }}</td>
                                            <td>{{ formatPrice($tour->discount_price) }}</td>
                                            <td>{{ formatPrice($tour->price) }}</td>
                                            <td>{{ formatPrice($tour->child_price) }}</td>
                                            <td>
                                                <span
                                                    class="badge rounded-pill bg-{{ $tour->is_featured ? 'success' : 'danger' }}">
                                                    {{ $tour->is_featured ? 'Yes' : 'No' }}
                                                </span>
                                            </td>
                                            <td>
                                                <span
                                                    class="badge rounded-pill bg-{{ $tour->is_recommended ? 'success' : 'danger' }}">
                                                    {{ $tour->is_recommended ? 'Yes' : 'No' }}
                                                </span>
                                            </td>
                                            <td>
                                                <span
                                                    class="badge rounded-pill bg-{{ $tour->status === 'active' ? 'success' : 'danger' }}">
                                                    {{ ucfirst($tour->status) }}
                                                </span>
                                            </td>
                                            <td>{{ formatDateTime($tour->created_at) }}</td>
                                            <td>{{ formatDateTime($tour->updated_at) }}</td>
                                            <td>
                                                <div class="dropstart">
                                                    <button type="button" class="recent-act__icon dropdown-toggle"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class='bx bx-dots-vertical-rounded'></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="{{ route('admin.tours.edit', $tour->id) }}">
                                                                <i class="bx bx-edit"></i> Edit
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="{{ route('admin.tours.change-status', $tour->id) }}">
                                                                <i
                                                                    class="bx {{ $tour->status === 'active' ? 'bx-x' : 'bx-check' }}"></i>
                                                                {{ $tour->status === 'active' ? 'Make Inactive' : 'Make Active' }}
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <form action="{{ route('admin.tours.destroy', $tour->id) }}"
                                                                method="POST"
                                                                onsubmit="return confirm('Are you sure you want to delete?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="dropdown-item">
                                                                    <i class="bx bx-trash"></i> Delete
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
