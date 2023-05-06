function setupEventListeners() {
	$('.reservation-card').on('click', function(event) {
		if (!$(event.target).is('button') && !$(event.target).is('i')) {
			$(this).find('.reservation-details').slideToggle();
		}
	});

	$('.reservation').on('click', function() {
		var button = $(this);
		var reservationId = button.closest('.card').data('id');
		var action = button.hasClass('btn-success') ? 'accept' : 'cancel';
		axios.post('/admin/reservations/' + reservationId + '/' + action)
			.then(response => {
				if (action === 'accept') {
					button.html('<i class="fas fa-check"></i> ' + window.translations.accepted).prop('disabled', true);
					button.next().html('<i class="fas fa-times"></i> ' + window.translations.cancel).prop('disabled', false);
				} else {
					button.html('<i class="fas fa-times"></i> ' + window.translations.canceled).prop('disabled', true);
					button.prev().html('<i class="fas fa-check"></i> ' + window.translations.accept).prop('disabled', false);
				}
			})
			.catch(error => {
				// Handle error response here
				if (error.response && error.response.data && error.response.data.message) {
					alert(error.response.data.message);
				} else {
					alert('An error occurred while ' + action + 'ing the reservation.');
				}
			});
	});
}

setupEventListeners();

$('.filter-accepted, .filter-canceled, .show-all').on('click', function() {
	var status = $(this).hasClass('filter-accepted') ? 'accepted' : ($(this).hasClass('filter-canceled') ? 'canceled' : 'all');
	axios.get('/admin/reservations/' + status)
		.then(function(response) {
			$('.reservation-container').html(response.data);
			setupEventListeners();
		});
});