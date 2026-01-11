@extends('admin.layouts.main')
@section('content')
    <div class="col-md-12">
        <div class="dashboard-content">
            {{ Breadcrumbs::render('admin.provinces.index') }}
            <form id="bulkActionForm" method="POST" action="{{ route('admin.bulk-actions', ['resource' => 'provinces']) }}">
                @csrf
                <div class="table-container universal-table">
                    <div class="custom-sec">
                        <div class="custom-sec__header">
                            <div class="section-content">
                                <h3 class="heading">{{ $title }}</h3>
                            </div>
                            <a href="{{ route('admin.provinces.create') }}" class="themeBtn">Add New</a>
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
                                        <th>Country</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($provinces as $province)
                                        <tr>
                                            <td>
                                                <div class="selection item-select-container"><input type="checkbox"
                                                        class="bulk-item" name="bulk_select[]" value="{{ $province->id }}">
                                                </div>
                                            </td>
                                            <td>{{ $province->yalago_id ?? 'N/A' }}
                                            </td>
                                            <td>
                                                <a class="blue-link"
                                                    href="{{ route('admin.provinces.edit', $province->id) }}">
                                                    {{ $province->name ?? 'N/A' }}
                                                </a>
                                            </td>
                                            <td>{{ $province->country->name ?? 'N/A' }}
                                            </td>
                                            <td>
                                                <span
                                                    class="badge rounded-pill bg-{{ $province->status === 'active' ? 'success' : 'danger' }}">
                                                    {{ ucfirst($province->status) }}
                                                </span>
                                            </td>
                                            <td>{{ formatDateTime($province->created_at) }}</td>
                                            <td>
                                                <a onclick="return confirm('Are you sure you want to sync?')" style="white-space: nowrap;" href="" class="themeBtn"><i
                                                        class='bx bx-refresh'></i>Import Locations</a>
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
