<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    @if(session('participationError'))
    <div class="alert alert-danger">
        {{ session('participationError') }}
    </div>
    @endif
    <script src="../../js/lessor.js"></script>
    @foreach ($availableOffers as $availableOffer)
    <div>
        {{$availableOffer['id']}}
        {{$availableOffer['totalPrice']}}
        <a href="{{ route('lessor.apply', $availableOffer) }}">Apply</a>
        <a href="{{ route('offer.details', $availableOffer) }}">View Details</a>
    </div>
    @endforeach
</body>

</html>