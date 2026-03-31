<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Room</title>
    @vite(['resources/css/app.css', 'resources/js/server.js'])
</head>
<body>
    <p>Chat Room : </p>
    <div id="chat-messages" style="border: 1px solid #ccc; height: 200px; overflow-y: auto; margin-bottom: 10px; padding: 10px;">
    </div>

    <div id="chat-form">
        <input type="text" id="message-input" placeholder="Write a message...">
        <button type="button" id="send-btn">Send</button>
    </div>

    @foreach ($availableOffers as $availableOffer)
    <div>
        {{$availableOffer['id']}} - {{$availableOffer['totalPrice']}}
        <a href="{{ route('lessor.apply', $availableOffer) }}">Apply</a>
    </div>
    @endforeach
</body>

</html>