@extends('layout.master')
@section('content')
<div class="contentBody">
    <div class="row genRow1 border1">
        <div class="col-12">
            <div class="genBox">
                <p class="amount">{{$products_count}}</p>
                <p class="desc">New Products/Services</p>
                <p class="tagAbs xy-center">P</p>
            </div>
        </div>
        
    </div>

    
</div>
@endsection

@section('additional_scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
<script>
    $(document).ready(function() {

        
    })
</script>

@endsection