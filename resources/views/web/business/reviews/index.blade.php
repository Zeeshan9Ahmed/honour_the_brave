@extends('layout.master')
@section('content')
<div class="contentBody">
				<h1 class="heading pb-4 text-center">Reviews</h1>
				
				<div class="row subsRow">
                    @foreach($reviews as $review)
					<div class="col-lg-4 col-md-6 col-sm-12 col-12">
						<div class="reviewCard">
							<p class="heading pb-2">{{$review->user->full_name??"--"}}</p>
							<p class="subHeading pb-2">Comment:</p>
							<p class="desc">
								{{$review->review}}
							</p>
							
							
						</div>
					</div>
					@endforeach
					
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