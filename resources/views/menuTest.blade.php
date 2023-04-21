@extends('layout')
@section('content')
<style>
	.card-hover:hover {
		transform: scale(1.05);
		transition: all 0.2s ease-in-out;
	}
	.collapsing {
		-webkit-transition: none;
		transition: none;
		display: none;
	}
</style>
<div class="container" style="max-width: 80%;">
	
	<!-- Separator -->
	<x-separator image="/images/decorations/flourish2.png" text="Our recommendations" />

    <!-- Recommended Menus -->
    <div id="recommendedMenusCarousel" class="carousel slide my-4" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach ($recommendedMenus->chunk(3) as $chunk)
                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                    <div class="row">
                        @foreach ($chunk as $menu)
                            <div class="col-md-4">
                                <div class="card bg-dark text-white mx-auto" style="max-width: 20rem;">
                                    <img src="{{ '/images/' . $menu->image->image }}" alt="Menu Image" class="card-img-top">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $menu->name }}</h5>
                                        <p class="card-text"><!--{{ $menu->description }}--></p>
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
	
    <!-- Category Buttons -->
    <div class="btn-group my-4 d-flex justify-content-center" role="group">
        @foreach ($categories as $category)
            <button type="button" class="btn btn-secondary" data-bs-toggle="collapse" data-bs-target="#category{{ $category->id }}Menus" data-bs-parent="#categories">{{ $category->name }}</button>
        @endforeach
    </div>

    <!-- Category Menus -->
    <div id="categories" style="height: 700px;">
        @foreach ($categories as $category)
            <div class="collapse @if($loop->first) show @endif" id="category{{ $category->id }}Menus">
                <h2 class="my-4 text-center">{{ $category->name }}</h2>
                <div class="row">
                    @foreach ($category->menus as $menu)
                        <div class="col-md-4 mb-4">
							
							<!-- card -->
							<div class="card h-100 bg-dark text-white card-hover" data-bs-toggle="modal" data-bs-target="#menuModal{{ $menu->id }}">
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
					
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
	
</div>
<x-shadowed-image image="{{ asset('/images/menu/background.jpg') }}" text="Join us for dinner" height="450px"  />

<script>
	document.addEventListener('DOMContentLoaded', () => {
		const categories = document.querySelectorAll('#categories > .collapse');
		const categoryButtons = document.querySelectorAll('[data-bs-toggle="collapse"][data-bs-parent="#categories"]');

		const hideAllCategoriesExcept = (targetId) => {
			categories.forEach(category => {
				if (category.id !== targetId) {
					const collapseInstance = bootstrap.Collapse.getInstance(category);
					if (collapseInstance) {
						collapseInstance.hide();
					} else {
						category.classList.remove('show');
					}
				}
			});
		};

		categoryButtons.forEach(button => {
			button.addEventListener('click', () => {
				const targetId = button.getAttribute('data-bs-target').slice(1);
				hideAllCategoriesExcept(targetId);
			});
		});
	});
</script>

@stop