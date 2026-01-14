@if ($response['IsCancellable'])
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Charge</th>
                <th>Currency</th>
                <th>Valid Until</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @php
                $today = now();
                $buttonShown = false;
            @endphp

            @foreach ($response['CancellationPolicyStatic'][0]['CancellationCharges'] as $charge)
                @php
                    $expiry = \Carbon\Carbon::parse($charge['ExpiryDate']);
                    $isActive = $today->lte($expiry) && !$buttonShown;
                @endphp
                <tr class="{{ $isActive ? 'table-warning fw-bold' : '' }}">
                    <td>{{ $charge['Charge']['Amount'] }}</td>
                    <td>{{ $charge['Charge']['Currency'] }}</td>
                    <td>{{ $expiry->format('d M Y') }}</td>
                    <td>
                        @if ($isActive)
                            <form method="POST" action="{{ route('user.hotels.cancel', $booking->id) }}">
                                @csrf
                                <button class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure you want to cancel this booking?');">
                                    Cancel Booking
                                </button>
                            </form>
                            @php $buttonShown = true; @endphp
                        @else
                            —
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <p>This booking is not cancellable.</p>
@endif
