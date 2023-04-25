@foreach ($messages as $message)
    @include('dashboard.messageCard', ['message' => $message])
@endforeach