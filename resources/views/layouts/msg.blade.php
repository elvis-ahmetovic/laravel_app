@include('includes/header')

<body>

    <div class="private-messages toggled">
        @include('includes/navbar')

        @include('includes/conversations')

        @yield('messages')

        @yield('content')
    </div>
    
    <script type="text/javascript" src="{{ asset('js/conversations.js') }}"></script>
</body>
</html>