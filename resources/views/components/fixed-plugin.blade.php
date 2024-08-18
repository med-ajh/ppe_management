<div class="fixed-plugin">
    <a class="fixed-plugin-button text-dark position-fixed px-3 py-2" id="cart-icon" style="position: relative;">
        <i class="fa fa-shopping-basket py-2"></i>
        <span id="cart-item-count" class="badge badge-pill" style="position: absolute; top: -10px; right: -10px; font-size: 12px; background-color: orange; color: white; display: none; display: flex; align-items: center; justify-content: center; width: 24px; height: 24px; border-radius: 50%;"></span>
    </a>
    <div class="card shadow-lg d-none" style="width: 80%; max-width: 600px; margin: auto; border-radius: 30px;">
        <div class="card-header pb-0 pt-3">
            <div class="{{ (Request::is('rtl') ? 'float-end' : 'float-start') }}">
                <h5 class="mt-3 mb-0">Request Manager</h5>
            </div>
            <div class="{{ (Request::is('rtl') ? 'float-start mt-4' : 'float-end mt-4') }}">
                <button class="btn btn-link text-dark p-0 fixed-plugin-close-button">
                    <i class="fa fa-close"></i>
                </button>
            </div>
        </div>
        <hr class="horizontal dark my-1">
        <div class="card-body pt-sm-3 pt-0">
            <div id="cart-content">
                <!-- Cart content will be loaded here -->
            </div>
            <hr class="horizontal dark my-sm-4">
            <form id="cart-confirm-form" action="{{ route('cart.confirmRequests') }}" method="POST">
                @csrf
                <button type="submit" class="btn bg-gradient-dark w-100">Confirm Requests</button>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Load cart and item count when the document is ready
    loadCart();

    $('.fixed-plugin-button').click(function() {
        $('.fixed-plugin .card').toggleClass('d-none');
        loadCart(); // Load cart data when the card is shown
    });

    $('.fixed-plugin-close-button').click(function() {
        $('.fixed-plugin .card').addClass('d-none');
    });

    function loadCart() {
        $.get('{{ route('cart.show') }}', function(data) {
            let html = '';
            let uniqueItemCount = data.items.length; // Count of unique items

            if (uniqueItemCount === 0) {
                html = '<p>Your cart is empty.</p>';
                $('#cart-item-count').text('').hide(); // Hide badge if no items
            } else {
                html += '<table class="table">' +
                            '<thead>' +
                                '<tr>' +
                                    '<th>Image</th>' +
                                    '<th>Item</th>' +
                                    '<th>Size</th>' +
                                    '<th>Quantity</th>' +
                                '</tr>' +
                            '</thead>' +
                            '<tbody>';

                data.items.forEach(function(item) {
                    html += '<tr>' +
                                '<td>' +
                                    '<img src="{{ asset('storage/') }}/' + item.item.image + '" alt="' + item.item.name + '" style="width: 100%; max-width: 100px; height: auto; border-radius: 8px;">' +
                                '</td>' +
                                '<td>' + item.item.name + '</td>' +
                                '<td>' + item.size + '</td>' +
                                '<td>' + item.quantity + '</td>' +
                            '</tr>';
                });

                html += '</tbody>' +
                        '</table>';

                // Show the badge with the count of unique items
                $('#cart-item-count').text(uniqueItemCount).show();
            }

            $('#cart-content').html(html);
        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.error('Error fetching cart data:', textStatus, errorThrown);
        });
    }

    $('#cart-confirm-form').on('submit', function(e) {
        e.preventDefault(); // Prevent default form submission

        $.post($(this).attr('action'), $(this).serialize(), function(response) {
            if (response.success) {
                alert('Requests confirmed!');
                window.location.href = '{{ route('requests.follow') }}'; // Redirect to requests/follow view
            } else {
                alert('Failed to confirm requests: ' + (response.error || 'Unknown error'));
            }
        }).fail(function(jqXHR, textStatus, errorThrown) {
            alert('Request failed: ' + textStatus);
        });
    });
});
</script>
