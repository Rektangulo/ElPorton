@extends('layout')
@section('content')
<style>
	.card-hover:hover {
		transform: scale(1.05);
		transition: all 0.2s ease-in-out;
	}
	.nav-tabs .nav-link:not(.active) {
		color: white;
	}
</style>
<div class="container" style="max-width: 80%;">
	
	<!-- Separator -->
	<x-separator image="/images/decorations/flourish2.png" text="Our recommendations"/>

    <!-- Recommended Menus -->
    <div id="recommendedMenusCarousel" class="carousel slide my-4" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach ($recommendedMenus->chunk(3) as $chunk)
                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                    <div class="row">
                        @foreach ($chunk as $menu)
                            <div class="col-md-4">
								
								<!-- card -->
                                <div class="card bg-dark text-white mx-auto" style="max-width: 20rem;" data-bs-toggle="modal" data-bs-target="#menuModal{{ $menu->id }}">
                                    <img src="{{ '/images/' . $menu->image->image }}" alt="Menu Image" class="card-img-top">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $menu->name }}</h5>
                                        <p class="card-text"><!--{{ $menu->description }}--></p>
                                    </div>
                                </div>
								
								<!-- modal -->
								
								<div class="modal fade" id="menuModal{{ $menu->id }}" tabindex="-1" aria-labelledby="menuModalLabel{{ $menu->id }}" aria-hidden="true">
									<div class="modal-dialog modal-dialog-centered">
										<div class="modal-content bg-dark text-white">
											<div class="modal-header">
												<h5 class="modal-title" id="menuModalLabel{{ $menu->id }}">{{ $menu->name }}</h5>
												<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
											</div>
											<div class="modal-body">
												<img src="{{ '/images/' . $menu->image->image }}" alt="Menu Image" class="img-fluid mb-3">
												<p>{{ $menu->description }}</p>
												<p>Price: {{ $menu->price }}€</p>
												<p>Tags: {{ $menu->tags->pluck('name')->join(', ') }}</p>
												<p>Category: {{ $menu->category->name }}</p>
											</div>
										</div>
									</div>
								</div>
								
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#recommendedMenusCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#recommendedMenusCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
	
	<!-- Separator -->
	<x-separator image="/images/decorations/flourish1.png" text="Our dishes" />
	
    <!-- Category Tabs -->
	<ul class="nav nav-tabs my-4 d-flex justify-content-center" role="tablist">
		@foreach ($categories as $category)
			<li class="nav-item" role="presentation">
				<button class="nav-link  @if($loop->first) active @endif" id="category{{ $category->id }}-tab" data-bs-toggle="tab" data-bs-target="#category{{ $category->id }}Menus" type="button" role="tab" aria-controls="category{{ $category->id }}Menus" aria-selected="@if($loop->first) true @else false @endif">{{ $category->name }}</button>
			</li>
		@endforeach
	</ul>

	<!-- Category Menus -->
	<div class="tab-content" id="categories" style="min-height: 700px;">
		@foreach ($categories as $category)
			<div class="tab-pane fade @if($loop->first) show active @endif" id="category{{ $category->id }}Menus" role="tabpanel" aria-labelledby="category{{ $category->id }}-tab">
				<h2 class="my-4 text-center">{{ $category->name }}</h2>
				<div class="row">
					@foreach ($category->menus as $menu)
						<div class="col-md-6 mb-4">
							
							<!-- card -->
							<div class="card h-100 bg-dark text-white card-hover rounded-0" style="min-height: 150px;" data-bs-toggle="modal" data-bs-target="#menuModal{{ $menu->id }}">
								<div class="card-body overflow-auto">
									<div class="d-flex justify-content-between">
										<div>
											<h5 class="card-title">{{ $menu->name }}</h5>
										</div>
										<div>
											<h5 class="card-title fst-italic">{{ $menu->price }}€</h5>
										</div>
									</div>
									<p class="card-text fst-italic">{{ $menu->description }}</p>
								</div>
							</div>
							
							<!-- Menu Modal -->
							<div class="modal fade" id="menuModal{{ $menu->id }}" tabindex="-1" aria-labelledby="menuModalLabel{{ $menu->id }}" aria-hidden="true">
								<div class="modal-dialog modal-dialog-centered">
									<div class="modal-content bg-dark text-white">
										<div class="modal-header">
											<h5 class="modal-title" id="menuModalLabel{{ $menu->id }}">{{ $menu->name }}</h5>
											<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
										</div>
										<div class="modal-body">
											<img src="{{ '/images/' . $menu->image->image }}" alt="Menu Image" class="img-fluid mb-3">
											<p>{{ $menu->description }}</p>
											<p>Price: {{ $menu->price }}</p>
											<p>Tags: {{ $menu->tags->pluck('name')->join(', ') }}</p>
											<p>Category: {{ $menu->category->name }}</p>
										</div>
									</div>
								</div>
							</div>
							
						</div>
					@endforeach
				</div>
			</div>
		@endforeach
	</div>

</div>
<x-shadowed-image image="{{ asset('/images/menu/background.jpg') }}" text="Join us for dinner" height="450px" font-size="60px" shadow-opacity="0.6" />

@stop