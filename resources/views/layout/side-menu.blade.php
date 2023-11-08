<aside class="aside active">
	<a href="{{url('business/dashboard')}}" class="xy-center secLogo">
		<img src="{{asset('images/logoMain.png')}}" alt="img" class="logoMain">
		<img src="{{asset('images/logoResp.png')}}" alt="img" class="responsoveLogo img-fluid">
	</a>

	<a href="{{url('business/profile')}}" class="userIcon1 xy-center">
		<img src="{{asset('images/userMain.png')}}" alt="img">
	</a>
	
	<div class="profileimgMain">
		<img src="{{ auth()->user()->avatar?url('/public').auth()->user()->avatar:asset('images/user.png')}}" alt="">
		<a href="{{url('business/profile')}}" class="editProfile xy-center"><i class="fa-regular fa-pen-to-square"></i></a>
	</div>	

	<p class="name1">{{ auth()->user()->full_name }}</p>

	<ul class="list-unstyled navigation">
		<li>
			<a href="{{url('business/dashboard')}}" class="navItem" title="Dashboard">
				<span class="navIcon">
					<img src="{{asset('images/nav-icon1.png')}}" alt="img">
				</span>
				<span class="navText">Dashboard</span>
			</a>
		</li>
		<li>
			<a href="{{url('business/products')}}" class="navItem" title="Products">
				<span class="navIcon">
					<img src="{{asset('images/nav-icon2.png')}}" alt="img">
				</span>
				<span class="navText">Products</span>
			</a>
		</li>
		<li>
			<a href="{{url('business/subscription')}}" class="navItem" title="Subscription">
				<span class="navIcon">
					<img src="{{asset('images/nav-icon3.png')}}" alt="img">
				</span>
				<span class="navText">Subscription</span>
			</a>
		</li>

		<li>
			<a href="{{url('business/reviews')}}" class="navItem" title="Subscription">
				<span class="navIcon">
					<img src="{{asset('images/nav-icon4.png')}}" alt="img">
				</span>
				<span class="navText">Reviews</span>
			</a>
		</li>
	</ul>
	<a href="{{url('business/logout')}}" class="logoutBtn">
		<img src="{{asset('images/logout.png')}}" alt="img" class="logIcon">
		<img src="{{asset('images/logResp.png')}}" alt="img" class="logResp">
		<span class="logtext">Logout</span>
	</a>
</aside>