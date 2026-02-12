@extends('admin.layouts.main')
@section('content')
    <div class="col-md-12">
        <div class="dashboard-content">
            {{ Breadcrumbs::render('admin.flights.index') }}
            <form id="bulkActionForm" method="POST" action="{{ route('admin.bulk-actions', ['resource' => 'flights']) }}">
                @csrf
                <div class="table-container universal-table">
                    <div class="custom-sec">
                        <div class="custom-sec__header">
                            <div class="section-content">
                                <h3 class="heading">{{ $title }}</h3>
                            </div>
                            <a href="{{ route('admin.flights.create') }}" class="themeBtn">Add New</a>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-5">
                                <form class="custom-form">
                                    <div class="form-fields d-flex gap-3">
                                        <select class="field" id="bulkActions" name="bulk_actions" required>
                                            <option value="" disabled selected>Bulk Actions</option>
                                            <option value="active">Make Active</option>
                                            <option value="inactive">Make Inactive</option>
                                            <option value="delete">Delete</option>
                                        </select>
                                        <button type="submit" onclick="confirmBulkAction(event)" class="themeBtn">Apply</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th class="no-sort">
                                            <div class="selection select-all-container"><input type="checkbox" id="select-all"></div>
                                        </th>
                                        <th>Image</th>
                                        <th>Destination</th>
                                        <th>Route</th>
                                        <th>Price</th>
                                        <th>Is Featured</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($flights as $flight)
                                        <tr>
                                            <td>
                                                <div class="selection item-select-container"><input type="checkbox" class="bulk-item" name="bulk_select[]" value="{{ $flight->id }}"></div>
                                            </td>
                                            <td>
                                                @if ($flight->image)
                                                    <a href="{{ asset($flight->image) }}" data-fancybox="image">
                                                        <img src="{{ asset($flight->image) }}" alt="Flight" style="width: 80px; height: 50px; object-fit: cover;">
                                                    </a>
                                                @else
                                                    <span class="text-muted">No Image</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a class="blue-link" href="{{ route('admin.flights.edit', $flight->id) }}">
                                                    {{ $flight->destination_name ?? 'N/A' }}
                                                </a>
                                            </td>
                                            <td>
                                                <span class="badge bg-primary">{{ $flight->origin_code }}</span>
                                                <i class='bx bx-right-arrow-alt'></i>
                                                <span class="badge bg-success">{{ $flight->destination_code }}</span>
                                            </td>
                                            <td>
                                                <span class="fw-bold"><span class="dirham">D</span> {{ number_format($flight->price, 0) }}</span>
                                            </td>
                                            <td>
                                                <span
                                                    class="badge rounded-pill bg-{{ $flight->is_featured ? 'success' : 'danger' }}">
                                                    {{ $flight->is_featured ? 'Yes' : 'No' }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge rounded-pill bg-{{ $flight->status === 'active' ? 'success' : 'danger' }}">
                                                    {{ ucfirst($flight->status) }}
                                                </span>
                                            </td>
                                            <td>{{ formatDateTime($flight->created_at) }}</td>
                                            <td>
                                                <div class="dropstart">
                                                    <button type="button" class="recent-act__icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class='bx bx-dots-vertical-rounded'></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a class="dropdown-item" href="{{ route('admin.flights.edit', $flight->id) }}">
                                                                <i class="bx bx-edit"></i> Edit
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="{{ route('admin.flights.change-status', $flight->id) }}">
                                                                <i class="bx {{ $flight->status === 'active' ? 'bx-x' : 'bx-check' }}"></i>
                                                                Make {{ $flight->status === 'active' ? 'Inactive' : 'Active' }}
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <form action="{{ route('admin.flights.destroy', $flight->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete?')">
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
