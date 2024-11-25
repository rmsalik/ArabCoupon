<!DOCTYPE html>
<html lang="en">
@include('frontend.partials.head') 

<body>
    @include('frontend.partials.header')
    @include('frontend.partials.navbar')
    @yield('content')
    
    @include('frontend.partials.footer') 
    @include('frontend.partials.footer_scripts')
</body>
</html>
