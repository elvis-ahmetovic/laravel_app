@include('includes/header')

<body>

    <div class="administration toggled">
        @include('includes/sidebar')

        @yield('messages')

        @yield('content')
    </div>
    
    <script type="text/javascript" src="{{ asset('js/sidebar.js') }}"></script>
</body>
</html>