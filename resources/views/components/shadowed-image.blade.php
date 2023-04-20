<div class="position-relative shadowed-image">
    <img src="{{ $image }}" alt="" class="img-fluid w-100" style="height: {{ $height }}; object-fit: cover;">
    <div class="position-absolute w-100 h-100" style="top: 0; background-color: rgba(0, 0, 0, {{ $shadowOpacity }});"></div>
    <div class="position-absolute w-100 h-100 d-flex align-items-center justify-content-center text-white" style="top: 0;">
        <p class="text-center mx-auto" style="max-width: 60%; font-size: {{ $fontSize }};">{{ $text }}</p>
    </div>
</div>