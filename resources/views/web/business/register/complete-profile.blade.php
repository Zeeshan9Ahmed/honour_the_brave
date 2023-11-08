<!DOCTYPE html>
<html>

@include('layout.header')

<body>
    <section class="intial-sec">
        <div class="container-fluid p-0">
            <div class="intial-row xy-center">
                <div class="leftCol xy-center" style="background: url({{asset('images/login-bg-2.jpg')}})">
                    <div class="textBox">
                        <div class="loginLogo text-center marginAuto">
                            <img src="{{asset('images/loginLogo.png')}}" alt="img" class="img-fluid loginLogoImg">
                        </div>
                        <p class="loginHeading text-center">Complete Profile</p>

                        <form class="loginFrom mt-4" id="complete_profile_form" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="avatar-upload compProfileImg">
                                <div class="avatar-edit">
                                    <input type='file' id="imageUpload" name="avatar" accept=".png, .jpg, .jpeg" />
                                    <label for="imageUpload" class="xy-center uploadImgCp">
                                        <img src="{{asset('images/upload.png')}}" class="uploadImg101" alt="img">
                                    </label>
                                </div>
                                <div class="avatar-preview compProfileImg2">
                                    <div id="imagePreview" style="background-image: url({{ auth()->user()->avatar??asset('images/user.png')}});">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group relClass mb-3">
                                <input type="text" placeholder="Business Name" id="business_name" name="business_name" class="inputItemMain">
                                <p class="inputIcon absClass xy-center">
                                    <img src="{{asset('images/login-icon4.png')}}" alt="img" class="w-100">
                                </p>
                            </div>
                            <div class="form-group relClass mb-3">
                                <select name="category_id" id="category_id" class="inputItemMain selectType">
                                    <option value="">Select Business Category</option>
                                    @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->category_name}}</option>
                                    @endforeach
                                </select>
                                <p class="inputIcon absClass xy-center">
                                    <img src="{{asset('images/catrgory-icon.png')}}" alt="img" class="w-100">
                                </p>
                            </div>
                            <div class="form-group relClass mb-3">
                                <input type="tel" placeholder="Phone Number" id="phone_number" name="phone_number" value="+1 " maxlength="17" class="inputItemMain">
                                <p class="inputIcon absClass xy-center">
                                    <img src="{{asset('images/login-icon7.png')}}" alt="img" class="w-100">
                                </p>
                            </div>
                            <div class="form-group relClass mb-3">
                                <input type="email" placeholder="Email Address" value="{{auth()->user()->email}}" class="inputItemMain" disabled>
                                <p class="inputIcon absClass xy-center">
                                    <img src="{{asset('images/login-icon1.png')}}" alt="img" class="w-100">
                                </p>
                            </div>
                            <div class="form-group relClass mb-3">
                                <input type="text" placeholder="Address" name="address" id="address" value="" class="inputItemMain">
                                <input type="hidden" name="latitude" id="latitude">
                                <input type="hidden" name="longitude" id="longitude">
                                <p class="inputIcon absClass xy-center">
                                    <img src="{{asset('images/address-icon.png')}}" alt="img" class="w-100">
                                </p>
                            </div>
                            {{-- 
                                <div class="form-group relClass mb-3">
                                <input type="url" placeholder="Website" id="website" name="website" class="inputItemMain">
                                <p class="inputIcon absClass xy-center">
                                    <img src="{{asset('images/login-icon6.png')}}" alt="img" class="w-100">
                                </p>
                            </div>


                            <div class="form-group relClass mb-3">
                                <input type="url" placeholder="Facebook" id="facebook" name="facebook" class="inputItemMain">
                                <p class="inputIcon absClass xy-center">
                                    <img src="{{asset('images/login-icon8.png')}}" alt="img" class="w-100 fbiCon">
                                </p>
                            </div>
                            <div class="form-group relClass mb-3">
                                <input type="url" placeholder="Instagram" id="instagram" name="instagram" class="inputItemMain">
                                <p class="inputIcon absClass xy-center">
                                    <img src="{{asset('images/instagram-icon.png')}}" alt="img" class="w-100">
                                </p>
                            </div>
                            <div class="form-group relClass mb-3">
                                <input type="url" placeholder="Twitter" id="twitter" name="twitter" class="inputItemMain">
                                <p class="inputIcon absClass xy-center">
                                    <img src="{{asset('images/twitter-icon.png')}}" alt="img" class="w-100">
                                </p>
                            </div>
                            <div class="form-group relClass mb-3">
                                <input type="url" placeholder="LinkedIn" id="linkedIn" name="linkedIn" class="inputItemMain">
                                <p class="inputIcon absClass xy-center">
                                    <img src="{{asset('images/linkedin-icon.png')}}" alt="img" class="w-100">
                                </p>
                            </div>
                                --}}
                            {{-- <div class="col-6 xy-center justify-content-end">
                                    <a href="#!" class="addMoreBtn">
                                        <span>Add More</span>
                                        <img src="{{asset('images/add-icon.png')}}" alt="img" class="ms-2">
                            </a>
                    </div>--}}

                    <div class="form-group relClass mt-4">
                        <button type="button" class="genBtn loginBtn" id="complete_profile_btn">Done</button>
                    </div>
                    </form>
                </div>
            </div>

            <div class="rightCol">
                <div class="mobileAbs">
                    <img src="{{asset('images/mobile.png')}}" alt="img" class="img-fluid">
                </div>
                <img src="{{asset('images/ellipse1.png')}}" alt="img" class="ellipse1 img-fluid">
                <img src="{{asset('images/ellipse2.png')}}" alt="img" class="ellipse2 img-fluid">
            </div>
        </div>
        </div>
    </section>
    @include('layout.footer')
    <script src="https://maps.google.com/maps/api/js?key=AIzaSyBmaS0B0qwokES4a_CiFNVkVJGkimXkNsk&libraries=places&callback=initAutocomplete" type="text/javascript"></script>

    <script>
        google.maps.event.addDomListener(window, 'load', initialize);

        function initialize() {
            var input = document.getElementById('address');
            var autocomplete = new google.maps.places.Autocomplete(input);
            autocomplete.addListener('place_changed', function() {
                var place = autocomplete.getPlace();
                $('#latitude').val(place.geometry['location'].lat());
                $('#longitude').val(place.geometry['location'].lng());
            });
        }
    </script>
    <script>
        $(document).ready(function() {
            function isWebsite(url) {
                return valid = /^(ftp|http|https):\/\/[^ "]+$/.test(url);
            }

            function validateFacebookUrl(facebook_url) {
                var pattern = /^(?:(?:http|https):\/\/)?(?:www.)?facebook.com\/(?:(?:\w)*#!\/)?(?:pages\/)?(?:[?\w\-]*\/)?(?:profile.php\?id=(?=\d.*))?([\w\-]*)?$/;
                return pattern.test(facebook_url);
            }

            function validateTwitterUrl(twitter_url) {
                var pattern = /(?:http:\/\/)?(?:www\.)?twitter\.com\/(?:(?:\w)*#!\/)?(?:pages\/)?(?:[\w\-]*\/)*([\w\-]*)/;
                return pattern.test(twitter_url);
            }

            function validateLinkedInUrl(linkedIn_url) {
                var pattern = /((https?:\/\/)?((www|\w\w)\.)?linkedin\.com\/)((([\w]{2,3})?)|([^\/]+\/(([\w|\d-&#?=])+\/?){1,}))$/;
                return pattern.test(linkedIn_url);
            }

            function validateInstagramUrl(linkedIn_url) {
                var pattern = /((https?:\/\/)?((www|\w\w)\.)?instagram\.com\/)((([\w]{2,3})?)|([^\/]+\/(([\w|\d-&#?=])+\/?){1,}))$/;
                return pattern.test(linkedIn_url);
            }


            $(document).on('keydown', function(e) {
                if (e.keyCode == 8 && $('#phone_number').is(":focus") && $('#phone_number').val().length < 4) {
                    e.preventDefault();
                }
            });
            $("#phone_number").keypress(function(e) {

                if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                    return false;
                }

                var curchr = this.value.length;
                var curval = $(this).val();
                if (curchr == 6 && curval.indexOf("(") <= -1) {
                    $(this).val("+1 (" + curval.replace("+1 ", "") + ")" + "-");
                } else if (curchr == 6 && curval.indexOf("(") > -1) {
                    $(this).val(curval + ")-");
                } else if (curchr == 12 && curval.indexOf(")") > -1) {
                    $(this).val(curval + "-");
                } else if (curchr == 9) {
                    $(this).val(curval + "-");
                    $(this).attr('maxlength', '14');
                }


            });

            $(document).on('click', '#complete_profile_btn', function(event) {
                
                
                event.preventDefault();
                var business_name = $("#business_name").val()
                var category_id = $("#category_id").val()
                var phone_number = $("#phone_number").val()
                var address = $('#address').val()
                var latitude = $('#latitude').val()

                var website = $("#website").val()
                var facebook = $("#facebook").val()
                var instagram = $("#instagram").val()
                var twitter = $("#twitter").val()
                var linkedIn = $("#linkedIn").val()
                if (!business_name) {
                    not('Business Name field is required', 'error');
                    return;
                } else if (!category_id) {
                    not('Business Category Field is required.', 'error');
                    return;
                } else if (!phone_number) {
                    not('Phone Number Field is required.', 'error');
                    return;
                } else if (phone_number.length == 3) {
                    not('Phone Number Field is required.', 'error');
                    return;
                } else if (phone_number.length < 17) {
                    not('Phone Number is not a valid', 'error')
                    return;

                } else if (!address) {
                    not('Address Field is required', 'error')
                    return;

                } else if (!latitude) {
                    not('Please Select A valid Location', 'error')
                    return;

                } 
                // else if (website && !isWebsite(website)) {
                //     not('Please provide a valid website Url.', 'error');
                //     return;
                // } else if (facebook && !validateFacebookUrl(facebook)) {
                //     console.log(instagram, 'insteaaaaaaaaaaaaaaaa');

                //     not('Please provide a valid Facebook Url.', 'error');
                //     return;
                // } else if (instagram && !validateInstagramUrl(instagram)) {

                //     not('Please provide a valid Instagram Url.', 'error');
                //     return;
                // } else if (twitter && !validateTwitterUrl(twitter)) {
                //     not('Please provide a valid Twitter Url.', 'error');
                //     return;
                // } else if (linkedIn) {
                //     if (!validateLinkedInUrl(linkedIn)) {
                //         not('Please provide a valid LinkedIn Url.', 'error');
                //         return;
                //     }
                // }

                $.ajax({
                    url: "{{ url('business/update-profile') }}",
                    method: "POST",
                    data: new FormData(document.getElementById('complete_profile_form')),
                    dataType: 'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(response, textStatus, jqXHR) {
                        if (response.status == 1) {
                            let colour = 'success';
                            if (response.data) {
                                localStorage.setItem('email', response.data.email)
                                localStorage.setItem('type', response.data.type)
                                colour = 'error'
                            }
                            not(response.message, colour);
                            window.location.href = response.redirect_url;

                        } else {
                            not(response.message, 'error');

                        }

                    },
                    error: function(jqXHR, exception) {
                        let data = JSON.parse(jqXHR.responseText);
                        not(data.message, 'error');
                    }
                });
                return;
                $.post("{{url('business/update-profile')}}", $('#complete_profile_form').serialize(), function(response) {
                    if (response.status > 0) {
                        let colour = 'success';
                        if (response.data) {
                            localStorage.setItem('email', response.data.email)
                            localStorage.setItem('type', response.data.type)
                            colour = 'error'
                        }
                        not(response.message, colour);
                        window.location.href = response.redirect_url;
                    } else {
                        not(response.message, 'error');
                    }
                }, 'json');
            });


        });
    </script>


</body>

</html>