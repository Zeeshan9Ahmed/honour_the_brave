<!DOCTYPE html>
<html>

@include('layout.header')

<body>



    <section class="genSec">
        <div class="genRow">
            <!-- side menu start-->
            @include('layout.side-menu')

            <!-- side menu end-->

            <div class="mainContent active">

                <!-- header bar start-->
                @include('layout.header-bar')

                @yield('content')

                <!-- header bar end-->

                
            </div>
        </div>
    </section>

    @if(Session::has('success')) <input type="hidden" id="mSg" color="success" value="{{ Session::get('success') }}"> @endif
    @if(Session::has('error')) <input type="hidden" id="mSg" color="error" value="{{ Session::get('error') }}"> @endif

    @include('layout.footer')




</body>

</html>