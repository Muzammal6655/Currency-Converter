<!-- File: resources/views/currency-converter.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Currency Converter</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<div class="container mt-5">
    <h2>Currency Converter</h2>

    <!-- will append ajax result in this div -->
    <div class="alert success_result"></div>
    <!-- ------------------------------------ -->

    <form id="currency_converter_form" method="POST">
        @csrf
        <div class="form-group">
            <label for="amount">Amount:</label>
            <input type="number" class="form-control" id="amount" name="amount" value="{{ old('amount') }}" required>
        </div>
        <div class="form-group">
            <label for="from_currency">From:</label>
            <select class="form-control" id="from_currency" name="from_currency" required>
                <!-- currencies symbol array -->
                @foreach ($symbols as $symbol)
                    <option value="{{ $symbol }}">{{ $symbol }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="to_currency">To:</label>
            <select class="form-control" id="to_currency" name="to_currency" required>
                @foreach ($symbols as $symbol)
                    <option value="{{ $symbol }}">{{ $symbol }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" id="convert_btn" class="btn btn-primary">Convert</button>
    </form>
</div>

<script>
    $(document).ready(function() {
        var symbols = {!! json_encode($symbols) !!};


        // Event listener for form submission
        $('#currency_converter_form').on('submit', function(e) {
            e.preventDefault(); // Prevent the form from submitting normally

            // serialize the form data into string
            var formData = $('#currency_converter_form').serialize();
            $.ajax({
                url: '/convert',
                method: 'POST',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        $('.success_result').empty();
                        $('.success_result').addClass('alert-success');
                        $('.success_result').append(response.amount + ' ' + response.currency_from + ' = ' + response.converted_amount + ' ' + response.currency_to);
                    } else {
                        $('.success_result').empty();
                        $('.success_result').addClass('alert-danger');
                        $('.success_result').append('Conversion failed: ' + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error converting currency:', error);
                    alert('Conversion failed. Please try again.');
                }
            });
        });


        function updateToCurrencyOptions() {
            var fromCurrency = $('#from_currency').val();
            var selectedToCurrency = $('#to_currency').val();

            // map the currency symbols array and generate the <option> in to_currency except the one select in from
            var toOptions = symbols.map(symbol => {
                if (symbol != fromCurrency) {
                    return `<option value="${symbol}" ${symbol === selectedToCurrency ? 'selected' : ''}>${symbol}</option>`;
                }
            }).join('');

            $('#to_currency').html(toOptions);
        }

        function updateFromCurrencyOptions() {
            var toCurrency = $('#to_currency').val();
            var selectedFromCurrency = $('#from_currency').val();

            // map the currency symbols array and generate the <option> in from_currency except the one select in 'To'
            var fromOptions = symbols.map(symbol => {
                if (symbol != toCurrency) {
                    return `<option value="${symbol}" ${symbol === selectedFromCurrency ? 'selected' : ''}>${symbol}</option>`;
                }
            }).join('');

            $('#from_currency').html(fromOptions);
        }

        // Event listener for "From" currency dropdown change
        $('#from_currency').on('change', function() {
            updateToCurrencyOptions(); // Update "To" currency options dynamically
        });

        // Event listener for "To" currency dropdown change
        $('#to_currency').on('change', function() {
            updateFromCurrencyOptions(); // Update "From" currency options dynamically
        });

        // Initialize currency options on page load
        updateToCurrencyOptions();
        updateFromCurrencyOptions();
    });
</script>

</body>
</html>
