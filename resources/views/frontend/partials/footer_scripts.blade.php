   <!-- Bootstrap JS and dependencies -->
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
   integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
   crossorigin="anonymous"></script>
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
   <script src="{{asset('frontend/js/index.js')}}"></script>
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   <script>
    var triggerClick=0;
    $(document).ready(function() {



    // Check if `country_id` exists in the URL query parameters
        const urlParams = new URLSearchParams(window.location.search);
        let countryId = urlParams.get('country_id');

    // If `country_id` is not in the query parameters, get it from the URL segments
        if (!countryId) {
            const urlSegments = window.location.pathname.split('/');
        countryId = urlSegments[3]; // Adjust index based on segment position
    }

    if (countryId) {
        // Find the matching country option in the dropdown
        const selectedOption = $('.country-option').filter(function() {
            return $(this).data('country-id') == countryId;
        });

        if (selectedOption.length) {
            // Update the displayed country name and flag
            $('#selectedCountry').text(selectedOption.data('country'));
            $('#selectedFlag').attr('src', selectedOption.data('flag'));
        }
    }









    $('#countryMenu .country-option').on("click", function() {
        const storedCountry = JSON.parse(localStorage.getItem('selectedCountry'));
        let selectedCountryId = $(this).data('country-id'); // Ensure this data attribute is set in your Blade template
        // let selectedCountryId = storedCountry.id; // Ensure this data attribute is set in your Blade template
        // alert(selectedCountryId);
        // Update selected country display
        let selectedCountry = $(this).data('country');
        // let selectedCountry = storedCountry.name;
        let selectedFlag = $(this).data('flag');
        // let selectedFlag = storedCountry.flag;

        // Update the button's content
        $('#selectedCountry').text(selectedCountry);
        $('#selectedFlag').attr('src', selectedFlag).show(); // Show the flag image

        $.ajax({
            url: '/getBrandsByCountry', // Update with your actual endpoint
            type: 'GET',
            data: { country_id: selectedCountryId },
            success: function(response) {
                // Update brand cards
                $('#brandContainer').html(''); // Clear previous messages

                // Optional: Display the count of brands
                $('#brand_count').text('(' + response.count + ') Stores ');

                // Check if there are no brands found
                if (response.count === 0) {
                    $('#brandContainer').html('<div class="text-center">No brands found for this country.</div>');
                    $("#view_all").hide();
                } else {
                    // alert(selectedCountry);
                    updateBrandCards(response.brands);
                    //if(triggerClick==0){
                    updateLatestBrands(response.latest_brands);
                    //}
                    $("#view_all").show();
                    get_brands_by_country();
                    dynamically_custom_selection();
                    $(".selectedCountry ").text(selectedCountry);
                    $('input[type="radio"][data-country-id="' + selectedCountryId + '"]').prop('checked', true);
                    localStorage.setItem(
                        'selectedCountry',
                        JSON.stringify({ id: selectedCountryId, name: selectedCountry, flag: selectedFlag })
                        );
                }
            },
            error: function(xhr) {
                console.error('Error fetching brands:', xhr);
                $('#brandContainer').html('<div class="text-center">An error occurred while fetching brands. Please try again.</div>');
            }
        });
    });

    // Event listener for the image click
    $('#staticBackdrop').on('show.bs.modal', function(event) {
    // Get the image element that triggered the modal
        var button = $(event.relatedTarget);

    // Extract data attributes from the clicked element
        var brandName = button.data('name');
        var description = button.data('description');
        var coupon_no = button.data('coupon_no');
        var coupon_id = button.data('coupon_id');
        var percentage = button.data('percentage');
        var profileImage = button.data('profile_image_url');
        var storeLink = button.data('store_link');
        if (!/^https?:\/\//i.test(storeLink)) {
        storeLink = 'http://' + storeLink;  // Prepend http:// if missing
        }
        // alert(description);
        //console.log(coupon_id);
       // console.log(storeLink);
    // Encode coupon_no for use in URLs
var encodedCoupon = encodeURIComponent(coupon_no);

    // Social media share links with encoded coupon_no
var fb_share_link = `https://www.facebook.com/sharer/sharer.php?u=${encodedCoupon}`;
var whatsapp_share_link = `https://api.whatsapp.com/send?text=${encodedCoupon}`;
var twitter_share_link = `https://twitter.com/intent/tweet?url=${encodedCoupon}`;


    // Set the modal content dynamically
var modal = $(this);
modal.find('#name').text(brandName);
modal.find('#description').text(description);
modal.find('#percentage').text((percentage ? percentage : 0) + '% off');
modal.find('#coupon_no').val(coupon_no);
modal.find('#visit_store').attr('href', storeLink);
modal.find('#facebook_share_link').attr('href', fb_share_link);
modal.find('#whatsapp_share_link').attr('href', whatsapp_share_link);
modal.find('#twitter_share_link').attr('href', twitter_share_link);
    modal.find('#brand_image').attr('src', profileImage); // Change src attribute
    modal.find('#like_coupon').attr('data-coupon_id', coupon_id);
    modal.find('#dislike_coupon').attr('data-coupon_id', coupon_id);
});




    // search 

 // On keyup event, get the selected country's data

    $("#coupons_search").keyup(function() {
         // Logs the pathname to verify
        console.log("Current Path:", path);
        var path = window.location.pathname;
        console.log("Current Path:", path);
         // Check if the current path is "offers"
        if (path.includes("offers")) {
        window.location.href = "{{url('/')}}"; // This will navigate to a new page
    }

    const selectedCountryId = $('#selectedCountry').text();
    const countryId = $('.country-option[data-country="'+selectedCountryId+'"]').data('country-id');
    var search_word = $(this).val();

    search_coupons_by_country(countryId,search_word);
});

    $(document).on('input', '#coupons_search_mobile', function () {
        var path = window.location.pathname;
        // console.log("Current Path:", path);
         // Check if the current path is "offers"
        if (path.includes("offers")) {
        window.location.href = "{{url('/')}}"; // This will navigate to a new page
    }

        const selectedCountryId = $('#selectedCountry').text();
        const countryId = $('.country-option[data-country="' + selectedCountryId + '"]').data('country-id');
        var search_word = $(this).val();
    // alert(countryId);
        search_coupons_by_country(countryId, search_word);
    });

    $('.brand_category').on('click', function() {
        const selectedCountryId = $('#selectedCountry').text();
        const countryId = $('.country-option[data-country="'+selectedCountryId+'"]').data('country-id');
        const categoryId = $(this).attr('data-category_id');


        const url = `/brands/${categoryId}/${countryId}`;

        window.location.href = url;
    });

    $(document).on("click","#like_coupon",function(){

        const coupon_id = $(this).data('coupon_id');
        const is_like   = $(this).data('is_like');
        like_dislike(coupon_id, is_like);
    });


    $(document).on("click","#dislike_coupon",function(){
        const coupon_id = $(this).data('coupon_id');
        const is_like   = $(this).data('is_like');
        like_dislike(coupon_id, is_like);
    });

    get_brands_by_country();


    $('#add-coupon').on('submit', function(event) {
    event.preventDefault(); // Prevent the default form submission

    // Get the selected country id
    const selectedCountryId = $('#selectedCountry').text(); // Adjust as needed
    const country_id = $('.country-option[data-country="'+selectedCountryId+'"]').data('country-id');

    // Get the form data
    var formData = $(this).serialize(); // Serialize form data

    // Append country_id to the form data
    formData += '&country_id=' + country_id;

    // Submit the form via AJAX
    $.ajax({
        url: $(this).attr('action'), // Use the form action URL
        type: 'POST',
        data: formData,
        success: function(response) {
            // Handle success (e.g., display a success message)
            // alert('Coupon added successfully!');
            Swal.fire({
                title: 'Success!',
                text: 'Coupon added successfully',
                icon: 'success',
                confirmButtonText: 'OK'
            });
            // Optionally, reset the form
            $('#add-coupon')[0].reset();
            $("#submitCoupon").modal('hide');
        },
        error: function(xhr) {
    // Check if response has a JSON structure with 'errors'
            var errors = xhr.responseJSON && xhr.responseJSON.errors;
            var errorMessage = '';

            if (errors) {
        // Loop through errors and collect messages
                $.each(errors, function(key, value) {
            errorMessage += value[0] + '\n'; // Collect the first error message for each field
        });
            } else {
        // Handle other error scenarios
                errorMessage = xhr.responseJSON && xhr.responseJSON.message
                ? xhr.responseJSON.message
                : 'An unknown error occurred. Please try again.';
            }

    // Display the error message using SweetAlert
            Swal.fire({
                title: 'Error!',
                text: errorMessage,
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }

    });
});

// Handle dropdown toggle behavior and form submission
    $('#navbarDropdown2').on('click', function (event) {
        const form = $('#addCouponMobile')[0];

    // Check if the form is valid
        if (!form.checkValidity()) {
        // If form is invalid, prevent the dropdown from toggling
        event.preventDefault(); // Prevent toggle action
        $(form).addClass('was-validated'); // Add validation feedback styles
        return; // Stop further execution
    }

    // Toggle the dropdown visibility
    if ($('#navbarDropdown2').hasClass('show')) {
        // If dropdown is currently open, close it
        $('#navbarDropdown2').removeClass('show');
        $(this).attr('aria-expanded', 'false');  // Update aria-expanded to false
    } else {
        // If dropdown is currently closed, open it
        $('#navbarDropdown2').addClass('show');
        $(this).attr('aria-expanded', 'true');  // Update aria-expanded to true
    }
});

// Handle form submission
    $('#addCouponMobile').on('submit', function (event) {
    event.preventDefault(); // Prevent default form submission

    const form = this;
    
    // Check if the form is valid before submitting
    if (!form.checkValidity()) {

        // Add validation styles if the form is invalid
        $(form).addClass('was-validated');
        return; // Stop form submission if validation fails
    }

    // If the form is valid, proceed with form submission via AJAX
    var formData = $(this).serialize();

    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: formData,
        success: function (response) {
            // Show success message using SweetAlert
            Swal.fire({
                title: 'Success!',
                text: 'Coupon submitted successfully.',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                // After success, toggle the dropdown
                const dropdownToggle = document.querySelector('#navbarDropdown2');
                if (dropdownToggle) {
                    $(dropdownToggle).dropdown('hide'); // Use Bootstrap dropdown method to close the dropdown
                }

                // Reset the form and remove validation styles
                $('#addCouponMobile')[0].reset();
                $('#addCouponMobile').removeClass('was-validated');
            });
        },
        error: function (xhr) {
            var errorMessage = xhr.responseJSON && xhr.responseJSON.message
            ? xhr.responseJSON.message
            : 'An error occurred. Please try again.';

            // Show error message using SweetAlert
            Swal.fire({
                title: 'Error!',
                text: errorMessage,
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    });
});






    dynamically_custom_selection();
    
     // On page load, check if a selected country exists in local storage
    const storedCountry = JSON.parse(localStorage.getItem('selectedCountry'));
    if (storedCountry) {
        // Update dropdown and display with stored country data
        $('.selectedCountry').text(storedCountry.name);
        $('#selectedFlag').attr('src', storedCountry.flag).attr('alt', `${storedCountry.name} Flag`);
        $('#countryDropdown').data('country-id', storedCountry.id);

        // Pre-select the corresponding radio button
        $(`.country-option[data-country-id="${storedCountry.id}"] input[type="radio"]`).prop('checked', true);
        // Pre-select the corresponding country option in the dropdown menu
        $(`.country-option[data-country-id="${storedCountry.id}"]`).addClass('selected');
        $("#selectedCountry").text(storedCountry.name);
        $('input[type="radio"][data-country-id="' + storedCountry.id + '"]').prop('checked', true);
        if (window.location.pathname.includes('/brands')) {
        return; // Exit the function, so the country selection won't affect the brands page
    }
    triggerClick=1;
    $('#countryMenu .country-option[data-country-id="' + storedCountry.id + '"]').trigger('click');
}

     // On page load, check if a selected language exists in local storage
const storedLanguage = localStorage.getItem('selectedLanguage');
if (storedLanguage) {
   // saved_languag(storedLanguage);

}
    // to active search input in mobile
$('.mobile-search').on('click', function () {
    $('.topbar-serch-sec.mobile-input.position-relative').toggleClass('active');
}); 



}); // document ready end

   function saved_languag(storedLanguage){
     // Update the displayed language in the button
    const storedCountry = JSON.parse(localStorage.getItem('selectedCountry'));
    $('#languageDropdown span#selectedLanguage').text(storedLanguage);
    $("#selectedCountry").text(storedCountry.name);
    // Optional: Alert the stored language for debugging
    $("#langDropdown span").text(storedLanguage);
    // Pre-select the corresponding language option
    $('.country-option .language').each(function () {
        if ($(this).text().trim() === storedLanguage) {
            $(this).closest('.country-option').find('.form-check-input').prop('checked', true);
        }
    });
}

function dynamically_custom_selection() {
    // alert('func'); // Confirm the function is triggered

    // Get selected country ID from the text content of #selectedCountry
    const selectedCountryId = $('#selectedCountry').text().trim(); // Trim to remove extra spaces
    // console.log('Selected Country:', selectedCountryId); // Debug log for selected country
    
    // Make sure countryId is valid and exists
    const country_id = $('.country-option[data-country="'+selectedCountryId+'"]').data('country-id');
    // console.log('Country ID:', country_id); // Debug log for country_id
    
    if (country_id) {
        // Debug: Check if any elements are selected
        //console.log('Number of .custom-links elements:', $('.custom-links').length);

        $('.custom-links').each(function() {
            var href = $(this).attr('href'); // Get current href
            // console.log('Current href:', href); // Debug log for href
            
            if (href) {
                var url = new URL(href);
                if (url.searchParams.has('country_id')) {
                    // Update the 'country_id' parameter if it exists
                    url.searchParams.set('country_id', country_id);
                    $(this).attr('href', url.toString());
                }else{
                    // If the href exists, proceed
                var urlParts = href.split('/'); // Split the URL by "/"
                
                // Check if the URL is in the expected format
                if (urlParts.length > 1) {
                    // Replace the last parameter with the new country_id
                    urlParts[urlParts.length - 1] = country_id;
                    
                    // Join the parts back and update the href
                    $(this).attr('href', urlParts.join('/'));
                } else {

                    console.error('URL format unexpected:', href); // Handle unexpected format
                }
            }

        } else {
                console.error('Href is empty or invalid:', href); // Handle invalid href
            }
        });
    } else {
        console.error('Country ID not found for selected country:', selectedCountryId);
    }
}



function get_brands_by_country(){
    const selectedCountryId = $('#selectedCountry').text();
    const countryId = $('.country-option[data-country="'+selectedCountryId+'"]').data('country-id');
            $('#brandSelect').empty(); // Clear the existing options
            $('#brandSelect').append('<option selected>Loading...</option>'); // Show loading option

            if (countryId) {
                $.ajax({
                    url: '/get-brands', // Update with your actual endpoint
                    type: 'GET',
                    data: { country_id: countryId },
                    success: function(data) {
                        $('#brandSelect').empty(); // Clear loading option
                        $('#brandSelect').append('<option selected>Select Brand</option>');
                        $.each(data.brands, function(index, brand) {
                            $('#brandSelect').append('<option value="' + brand.id + '">' + brand.name + '</option>');
                        });
                    },
                    error: function(xhr) {
                        console.error('Error fetching brands:', xhr);
                        $('#brandSelect').empty();
                        $('#brandSelect').append('<option selected>Error loading brands</option>');
                    }
                });
            } else {
                $('#brandSelect').empty();
                $('#brandSelect').append('<option selected>Select Brand</option>');
            }

        }

        function updateBrandCards(brands) {
    const brandContainer = $('#brandContainer'); // Ensure you have the correct ID for your container
    brandContainer.empty(); // Clear existing content

    // Loop through the brands and append them to the container
    $.each(brands, function(index, bdata) {
        // Check if the brand has at least one coupon, and use its URL, otherwise use '#'
        const couponUrl = bdata.coupons.length > 0 ? bdata.coupons[0].url_link : '#';
        const id = bdata.id;

        // Get coupon data for the modal
        const hasCoupons = bdata.coupons.length > 0;
        const country_id = hasCoupons ? bdata.coupons[0].country_id : 0;
        // alert(country_id);
        const couponData = hasCoupons ? bdata.coupons[0] : {};
        const profileImageUrl = bdata.profile_image_url || 'path/to/default/image.png'; // Fallback image
        const brandName = bdata.name || 'Unknown Brand'; // Fallback for brand name
        const percentage = hasCoupons ? couponData.percentage : 0; // Fallback for percentage

        // Construct the brand offers URL dynamically
        const brandOffersUrl = `/offers/${id}/${country_id}`;

        const cardHTML = `
        <div class="col-6 col-sm-6 col-md-6 col-lg-3">
        <div class="mini-cards bg-white">
        <div class="imni-card-image">
        <a href="${brandOffersUrl}" style="text-decoration: none;color:inherit" target="_blank">
        <img id="get_code" 
        src="${profileImageUrl}" 
        style="cursor: pointer;"
        class="img-fluid"  
        alt="${brandName}">

        </div>
        <h5 class="fw-bold text-center my-3 black-color">${brandName}</h5>
        </a>
        <div class="text-center py-1">
        <span class="persentage">
        <img class="img-fluid me-1" src="/frontend/images/persentage-sign.png" alt=""> ${percentage ? percentage : 0}% off
        </span>
        </div>
        </div>
        </div>
        `;
        brandContainer.append(cardHTML); // Append the new card to the container
    });
}



function updateLatestBrands(latestBrands) {

    // console.log(latestBrands);
    const latestBrandContainer = $('#latest_brands'); // Ensure you have the correct ID for your container
    latestBrandContainer.empty(); // Clear existing content

    // Loop through the latest brands and append them to the container
    $.each(latestBrands, function(index, lbdata) {
        // Check if there are coupons available
        const hasCoupons = lbdata.coupons.length > 0;
        const couponData = hasCoupons ? lbdata.coupons[0] : {};
        const storeLink  =  lbdata.coupons[0].url_link ;
        const profileImageUrl = hasCoupons ? lbdata.profile_image_url : 'path/to/default/image.png'; // Default image if not available
        const brandName = lbdata.name || 'Unknown Brand'; // Fallback for brand name if undefined
        const percentage = hasCoupons ? couponData.percentage : 0; // Fallback for percentage if undefined
            // console.log(lbdata.coupons[0].url_link);
        // console.log(couponData.id);
        const cardHTML = `
        <div class="col-6 col-sm-6 col-md-6 col-lg-3">
        <div class="mini-cards bg-white drop-shadow">
        <div class="imni-card-image">
        <img id="get_code" 
        data-name="${hasCoupons ? couponData.name : ''}"
        data-description="${ couponData.description }"
        data-coupon_no="${hasCoupons ? couponData.coupon_no : ''}"
        data-coupon_id="${hasCoupons ? couponData.id : ''}"
        data-percentage="${percentage ? percentage : 0}"
        data-profile_image_url="${lbdata.profile_image_url}"
        data-store_link="${storeLink}"
        class="img-fluid" 
        data-bs-toggle="modal" 
        data-bs-target="#staticBackdrop"
        src="${profileImageUrl}" 
        style="cursor: pointer;" 
        alt="${brandName}">
        </div>
        <p class="text-center my-3" data-bs-toggle="modal" data-bs-target="#staticBackdrop"
        id="get_code" 
        data-name="${hasCoupons ? couponData.name : ''}"
        data-description="${couponData.description }"
        data-coupon_no="${hasCoupons ? couponData.coupon_no : ''}"
        data-coupon_id="${hasCoupons ? couponData.id : ''}"
        data-percentage="${percentage ? percentage : 0}"
        data-profile_image_url="${lbdata.profile_image_url}"
        data-store_link="${storeLink}"
        style="cursor: pointer;">${brandName} Global coupon code (${hasCoupons ? couponData.coupon_no : ''}) with best...</p>
        <div class="text-center py-1">
        <button class="get-code-btn" 
        data-bs-toggle="modal" 
        data-bs-target="#staticBackdrop" 
        data-name="${hasCoupons ? couponData.name : ''}"
        data-description="${couponData.description }"
        data-coupon_no="${hasCoupons ? couponData.coupon_no : ''}"
        data-coupon_id="${hasCoupons ? couponData.id : ''}"
        data-percentage="${percentage ? percentage : 0}"
        data-profile_image_url="${lbdata.profile_image_url}"
        data-store_link="${storeLink}"
        data-percentage="${percentage ? percentage : 0}"
        data-profile_image_url="${lbdata.profile_image_url}">
        Get Code
        </button>
        </div>
        </div>
        </div>
        `;
        latestBrandContainer.append(cardHTML); // Append the new card to the container
    });
}

function search_coupons_by_country(country_id,search_word){


    $.ajax({
            url: '/getBrandsBySearch', // Update with your actual endpoint
            type: 'GET',
            data: { country_id: country_id, search_word:search_word},
            success: function(response) {
                // Update brand cards
                $('#brandContainer').html(''); // Clear previous messages

                // Optional: Display the count of brands
                $('#brand_count').text('(' + response.count + ') Stores ');

                // Check if there are no brands found
                if (response.count === 0) {
                    $('#brandContainer').html('<div class="text-center">No brands found for this country.</div>');
                    $("#view_all").hide();
                } else {
                    updateBrandCards(response.brands);
                    updateLatestBrands(response.latest_brands);
                    $("#view_all").show();
                    dynamically_custom_selection();
                }
            },
            error: function(xhr) {
                console.error('Error fetching brands:', xhr);
                $('#brandContainer').html('<div class="text-center">An error occurred while fetching brands. Please try again.</div>');
            }
        });

}

function redirectToAllCoupons() {
        // Assume `countryId` is dynamically obtained (e.g., from a selected country option)
  const selectedCountryId = $('#selectedCountry').text();
  const countryId = $('.country-option[data-country="'+selectedCountryId+'"]').data('country-id');
        // const countryId = $('#selectedCountry').data('country-id') || 'all'; // Fallback to default if needed
  window.location.href = `/allcoupons?country_id=${countryId}`;
}



function like_dislike(coupon_id, is_like) {
    $.ajax({
        url: '/coupon_like_dislike', 
        type: 'GET', 
        data: {
            coupon_id: coupon_id,
            is_like: is_like,
            _token: '{{ csrf_token() }}' 
        },
        success: function(response) {
            console.log('Response:', response);
            if(response.status==1){
                Swal.fire({
                    title: 'Like!',
                    text: response.message,
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            }else{
                Swal.fire({
                    title: 'Dislike',
                    text: response.message,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
            
        },
        error: function(xhr) {
            console.error('Error:', xhr);
        }
    });
}

$('.save-btn-lang').on('click', function() {
    save_mobile_lang();
});
function save_mobile_lang(){
     // Get the value of the checked radio button
    const selectedLanguage = $('.form-check-input:checked')
        .closest('.country-option') // Get the parent element of the checked input
        .find('.language') // Find the sibling element with the class 'language'
        .text().trim(); // Extract and trim the text content
        localStorage.setItem('selectedLanguage', selectedLanguage);
        saved_languag(selectedLanguage);
    // Close the modal
        $('#languageSelect').modal('hide');
    }
    $('.select-language').on('click', function () {
        const selectedLanguage = $(this).data('language');
        // Store the selected language in localStorage
        localStorage.setItem('selectedLanguage', selectedLanguage);
        saved_languag(selectedLanguage);
        
        $('#languageMenu').hide();
    });


</script>


<script>
    document.addEventListener('click', function (event) {
    // Ensure the click is from a button or its child by finding the closest button with class 'copy-btn'
        const copyButton = event.target.closest('.copy-btn');

        if (copyButton) {
        // Find the parent container
            const parent = copyButton.closest('.modal-input-sec');

        // Get the input field within the same container
            const couponInput = parent ? parent.querySelector('.coupon-input') : null;

            if (couponInput) {
            // Select the text in the input field
                couponInput.select();
            couponInput.setSelectionRange(0, 99999); // For mobile devices

            try {
                // Copy the text to the clipboard
                const successful = document.execCommand('copy');
                const msg = successful ? 'Copied to clipboard!' : 'Unable to copy';

                // Show alert with feedback
                Swal.fire({
                    title: 'Success!',
                    text: 'Copied',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            } catch (err) {
                alert('Oops, unable to copy');
                Swal.fire({
                    title: 'Fail!',
                    text: 'Can not copied',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                console.error('Copy error:', err);
            }
        } else {
            console.error('Input field not found within the container.');
        }
    }
});



    $(document).on('click', '.save-btn', function () {
        saved_country();
    });

    function saved_country(){
    // Get the selected radio button within the country option
        const selectedOption = $('.country-option input[type="radio"]:checked').closest('.country-option');

        if (selectedOption.length) {
        // Extract country details from data attributes
            const countryId = selectedOption.data('country-id');
            const countryName = selectedOption.data('country');
            const flagUrl = selectedOption.data('flag');

        // Update the displayed country name and flag
        $('.selectedCountry').text(countryName); // Update text in the dropdown or display area
        $('#selectedFlag').attr('src', flagUrl).attr('alt', `${countryName} Flag`); // Update flag image

        // Optionally store the country ID in a hidden input or dropdown element for further use
        $('#countryDropdown').data('country-id', countryId);
        localStorage.setItem(
            'selectedCountry',
            JSON.stringify({ id: countryId, name: countryName, flag: flagUrl })
            );
        // Close the modal
        $('#countarypick').modal('hide');
    } else {
        // Notify the user to select a country if none is selected
        alert('Please select a country before saving.');
    }
}
    // const mobileSearchIcon = document.querySelector('.mobile-search');
    //         const mobileInputDiv = document.querySelector('.mobile-input');
    //         mobileSearchIcon.addEventListener('click', () => {
    //             mobileInputDiv.classList.toggle('active');
    //         });

           //  language select js start
const languageDropdown = document.getElementById('languageDropdown');
const languageMenu = document.getElementById('languageMenu');
const selectedLanguageSpan = document.getElementById('selectedLanguage');
const languageOptions = document.querySelectorAll('.select-language');

languageDropdown.addEventListener('click', () => {
    const isMenuVisible = languageMenu.style.display === 'block';
    languageMenu.style.display = isMenuVisible ? 'none' : 'block';
});
languageOptions.forEach(option => {
    option.addEventListener('click', () => {
        const language = option.getAttribute('data-language');
        selectedLanguageSpan.textContent = language;
        languageMenu.style.display = 'none';
    });
});
document.addEventListener('click', (event) => {
    if (!languageDropdown.contains(event.target) && !languageMenu.contains(event.target)) {
        languageMenu.style.display = 'none';
    }
});
            //  language select js End

// Function to check and adjust scroll behavior
function updateBodyScroll() {
    const modalOpen = document.querySelector('.modal.show'); // Check if any modal is open
    if (modalOpen) {
        document.body.classList.add('body-scroll-disabled');
        document.body.classList.remove('body-scroll-enabled');
    } else {
        document.body.classList.remove('body-scroll-disabled');
        document.body.classList.add('body-scroll-enabled');
    }
}

// Event listeners for modal open/close
document.querySelectorAll('.modal').forEach(modal => {
    modal.addEventListener('shown.bs.modal', updateBodyScroll); // When modal opens
    modal.addEventListener('hidden.bs.modal', updateBodyScroll); // When modal closes
});

// Event listener for window resize
window.addEventListener('resize', updateBodyScroll);

// Initial call to ensure proper state on page load
updateBodyScroll();

</script>