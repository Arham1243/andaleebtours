@extends('admin.layouts.main')
@section('content')
    <div class="col-md-12">
        <div class="dashboard-content">
            {{ Breadcrumbs::render('admin.hotels.index') }}
            <form id="bulkActionForm" method="POST" action="{{ route('admin.bulk-actions', ['resource' => 'hotels']) }}">
                @csrf
                <div class="table-container universal-table">
                    <div class="custom-sec">
                        <div class="custom-sec__header">
                            <div class="section-content">
                                <h3 class="heading">{{ $title }}</h3>
                            </div>
                            <a href="{{ route('admin.hotels.create') }}" class="themeBtn">Add New</a>
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
                                        <button type="submit" onclick="confirmBulkAction(event)"
                                            class="themeBtn">Apply</button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-5">
                                <a onclick="return confirm('Are you sure you want to sync?')"
                                    href="{{ route('admin.hotels.sync.diff') }}" class="themeBtn">Sync Hotels from
                                    Yalago</a>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="custom-table">
                                <thead>
                                    <tr>
                                        <th class="no-sort">
                                            <div class="selection select-all-container"><input type="checkbox"
                                                    id="select-all"></div>
                                        </th>
                                        <th>Yalago ID</th>
                                        <th>Name</th>
                                        <th>Country</th>
                                        <th>Province</th>
                                        <th>Location</th>
                                        {{-- <th>Is Featured</th> --}}
                                        <th>Status</th>
                                        <th>Created At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($hotels as $hotel)
                                        <tr>
                                            <td>
                                                <div class="selection item-select-container"><input type="checkbox"
                                                        class="bulk-item" name="bulk_select[]" value="{{ $hotel->id }}">
                                                </div>
                                            </td>
                                            <td>{{ $hotel->yalago_id ?? 'N/A' }}
                                            </td>
                                            <td>
                                                <a class="blue-link" href="{{ route('admin.hotels.edit', $hotel->id) }}">
                                                    {{ $hotel->name ?? 'N/A' }}
                                                </a>
                                            </td>
                                            <td>{{ $hotel->country->name ?? 'N/A' }}
                                            </td>
                                            <td>{{ $hotel->province->name ?? 'N/A' }}
                                            </td>
                                            <td>{{ $hotel->location->name ?? 'N/A' }}
                                            </td>
                                            {{-- <td>
                                                <span
                                                    class="badge rounded-pill bg-{{ $hotel->is_featured ? 'success' : 'danger' }}">
                                                    {{ $hotel->is_featured ? 'Yes' : 'No' }}
                                                </span>
                                            </td> --}}
                                            <td>
                                                <span
                                                    class="badge rounded-pill bg-{{ $hotel->status === 'active' ? 'success' : 'danger' }}">
                                                    {{ ucfirst($hotel->status) }}
                                                </span>
                                            </td>
                                            <td>{{ formatDateTime($hotel->created_at) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="mt-4">
                                {{ $hotels->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
