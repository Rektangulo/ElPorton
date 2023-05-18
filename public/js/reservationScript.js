function setupEventListeners() {
    $('.reservation-card').off('click').on('click', function(event) {
        if (!$(event.target).is('button') && !$(event.target).is('i')) {
            $(this).find('.reservation-details').slideToggle();
        }
    });

    $('.reservation').off('click').on('click', function() {
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

var currentStatus = 'all';
var currentDate = null;

$('.reset-date').on('click', function() {
    currentStatus = 'all';
    currentDate = null;
    $('#search-date').val('');
    getReservations(currentStatus);
});

$('.filter-accepted, .filter-canceled, .show-all, .filter-pending').on('click', function() {
    currentStatus = $(this).hasClass('filter-accepted') ? 'accepted' : ($(this).hasClass('filter-canceled') ? 'canceled' : ($(this).hasClass('filter-pending') ? 'pending' : 'all'));
    getReservations(currentStatus, 1, currentDate);
});

$('.search-by-date').on('click', function() {
    var date = new Date($('#search-date').val());
    currentDate = date.getFullYear() + '-' + (date.getMonth() + 1).toString().padStart(2, '0') + '-' + date.getDate().toString().padStart(2, '0');
    currentStatus = null;
    getReservations(null, 1, currentDate);
});

function setupPaginationEventListeners() {
    $('.reservation-container').off('click', '.page-link').on('click', '.page-link', function(event) {
        if ($(this).closest('.custom-pagination').length > 0) {
            event.preventDefault();
            var page = $(this).closest('.page-item').find('.page-link').attr('href').split('page=')[1];
            getReservations(currentStatus, page, currentDate);
        }
    });
}

setupPaginationEventListeners();

function getReservations(status = null, page = 1, date = null) {
    var url = '/admin/reservations/';
    if (status && date) {
        url += status + '/date/' + date;
    } else if (status) {
        url += status;
    } else if (date) {
        url += 'date/' + date;
    }
    url += '?page=' + page;
    axios.get(url)
        .then(function(response) {
            $('.reservation-container').html(response.data);
            setupEventListeners();
			setupPaginationEventListeners();
        });
}

