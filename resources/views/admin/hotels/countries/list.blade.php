@extends('admin.layouts.main')
@section('content')
    <div class="col-md-12">
        <div class="dashboard-content">
            {{ Breadcrumbs::render('admin.countries.index') }}
            <form id="bulkActionForm" method="POST" action="{{ route('admin.bulk-actions', ['resource' => 'countries']) }}">
                @csrf
                <div class="table-container universal-table">
                    <div class="custom-sec">
                        <div class="custom-sec__header">
                            <div class="section-content">
                                <h3 class="heading">{{ $title }}</h3>
                            </div>
                            <a href="{{ route('admin.countries.create') }}" class="themeBtn">Add New</a>
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
                                <a onclick="return confirm('Are you sure you want to sync?')" href="{{ route('admin.countries.sync') }}" class="themeBtn">Sync countries from Yalago</a>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th class="no-sort">
                                            <div class="selection select-all-container"><input type="checkbox"
                                                    id="select-all"></div>
                                        </th>
                                        <th>Yalago ID</th>
                                        <th>Name</th>
                                        <th>Code</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($countries as $country)
                                        <tr>
                                            <td>
                                                <div class="selection item-select-container"><input type="checkbox"
                                                        class="bulk-item" name="bulk_select[]" value="{{ $country->id }}">
                                                </div>
                                            </td>
                                            <td>{{ $country->yalago_id ?? 'N/A' }}
                                            </td>
                                            <td>
                                                <a class="blue-link"
                                                    href="{{ route('admin.countries.edit', $country->id) }}">
                                                    {{ $country->name ?? 'N/A' }}
                                                </a>
                                            </td>
                                            <td>{{ $country->iso_code ?? 'N/A' }}
                                            </td>
                                            <td>
                                                <span
                                                    class="badge rounded-pill bg-{{ $country->status === 'active' ? 'success' : 'danger' }}">
                                                    {{ ucfirst($country->status) }}
                                                </span>
                                            </td>
                                            <td>{{ formatDateTime($country->created_at) }}</td>
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
