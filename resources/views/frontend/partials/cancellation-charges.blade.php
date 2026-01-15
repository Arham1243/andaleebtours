@if (!($charges['IsCancellable'] ?? false))
    <p class="text-danger">This booking is not cancellable.</p>
@else
    <h6 class="mb-3">
        Cancellation Policy - {{ $charges['CancellationPolicyStatic'][0]['RoomName'] }}
    </h6>

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
                $today = now()->toDateString();
                $actionShown = false;
            @endphp

            @foreach ($charges['CancellationPolicyStatic'][0]['CancellationCharges'] as $charge)
                @php
                    $expiry = substr($charge['ExpiryDate'], 0, 10);
                    $isCurrent = $today <= $expiry && !$actionShown;
                @endphp

                <tr @if ($isCurrent) class="table-warning fw-bold" @endif>
                    <td>{{ $charge['Charge']['Amount'] }}</td>
                    <td>{{ $charge['Charge']['Currency'] }}</td>
                    <td>{{ \Carbon\Carbon::parse($expiry)->format('d M Y') }}</td>
                    <td>
                        @if ($isCurrent)
                            <form method="POST" action="{{ route('user.hotels.cancel', $booking->id) }}">
                                @csrf
                                <button class="btn btn-danger btn-sm">
                                    Cancel Booking
                                </button>
                            </form>
                            @php $actionShown = true; @endphp
                        @else
                            —
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
