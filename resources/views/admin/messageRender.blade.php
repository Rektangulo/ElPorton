@foreach ($messages as $message)
    @include('admin.messageCard', ['message' => $message])
@endforeach