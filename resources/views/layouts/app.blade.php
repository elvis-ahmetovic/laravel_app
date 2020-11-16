@include('includes/header')

<body>

    @include('includes/navbar')
    
    @yield('messages')

    <main>
        @yield('content')
    </main>
</body>
</html>
