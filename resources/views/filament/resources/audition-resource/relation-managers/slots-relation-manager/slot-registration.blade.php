@if ($registrations->isEmpty())
    <p>No registrations found.</p>
@else
    <ul class="space-y-2">
        @foreach ($registrations as $reg)
            <li class="border p-2 rounded">
                <strong>{{ $reg->name }}</strong><br>
                Email: {{ $reg->email }}<br>
                Registered at: {{ $reg->created_at->format('M d, Y h:i A') }}
            </li>
        @endforeach
    </ul>
@endif