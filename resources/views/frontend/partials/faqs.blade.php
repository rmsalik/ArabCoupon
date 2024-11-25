
<section class="faqs-main">
        
            <!-- Accordion start -->
    <section class="accordion-main-sec py-4 py-md-5">
        <div class="container">
        <div class="container">
             @if(count($brands_offers) > 0)
            <h3 class="fw-bold black-color my-4 text-center mb-3">FAQs about {{$brands_offers[0]->brand_name}} Coupons And Promo Code</h3>
            @endif
        </div>
        
            <div class="row gy-3">                
                <div class="faqs-for-mobile-view">
                <div class="col-12 col-sm-12 col-md-11 col-lg-7 mx-auto">

                    <div class="accordion mb-3" id="accordionExample1">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button gap-4 align-items-start fw-bold" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true"
                                    aria-controls="collapseOne">
                                    <img class="icon-plus img-fluid" src="{{ asset('/images/plus-icon.png')}}" alt="">
                                    <img class="icon-minus img-fluid" src="{{ asset('/images/minus-icon.png')}}" alt="">
                                    What is the best discount code for {{$brands_offers[0]->brand_name}} in {{$brands_offers[0]->country_name}}?
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                                data-bs-parent="#accordionExample1">
                                <div class="accordion-body ms-5 pt-0">
                                    <p class="mb-0">Our app allows you to search for coupons by merchant name or
                                        category. Simply use the
                                        search bar at the top of the app to find relevant deals.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion mb-3" id="accordionExample2">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button gap-4 align-items-start fw-bold collapsed" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true"
                                    aria-controls="collapseTwo">
                                    <img class="icon-plus img-fluid" src="{{ asset('/images/plus-icon.png')}}" alt="">
                                    <img class="icon-minus img-fluid" src="{{ asset('/images/minus-icon.png')}}" alt="">
                                    How do I register for {{$brands_offers[0]->brand_name}} Online?
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                data-bs-parent="#accordionExample2">
                                <div class="accordion-body ms-5 pt-0">
                                    <p class="mb-0">Our app allows you to search for coupons by merchant name or
                                        category. Simply use the
                                        search bar at the top of the app to find relevant deals.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion mb-3" id="accordionExample3">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button gap-4 align-items-start fw-bold collapsed" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="true"
                                    aria-controls="collapseThree">
                                    <img class="icon-plus img-fluid" src="{{ asset('/images/plus-icon.png')}}" alt="">
                                    <img class="icon-minus img-fluid" src="{{ asset('/images/minus-icon.png')}}" alt="">
                                    How do I check my {{$brands_offers[0]->brand_name}} credits?
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse "
                                aria-labelledby="headingThree" data-bs-parent="#accordionExample3">
                                <div class="accordion-body ms-5 pt-0">
                                    <p class="mb-0">Our app allows you to search for coupons by merchant name or
                                        category. Simply use the
                                        search bar at the top of the app to find relevant deals.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion mb-3" id="accordionExample4">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingfour">
                                <button class="accordion-button gap-4 align-items-start fw-bold collapsed" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapsefour" aria-expanded="true"
                                    aria-controls="collapsefour">
                                    <img class="icon-plus img-fluid" src="{{ asset('/images/plus-icon.png')}}" alt="">
                                    <img class="icon-minus img-fluid" src="{{ asset('/images/minus-icon.png')}}" alt="">
                                    When are {{$brands_offers[0]->brand_name}} offers?
                                </button>
                            </h2>
                            <div id="collapsefour" class="accordion-collapse collapse "
                                aria-labelledby="headingfour" data-bs-parent="#accordionExample4">
                                <div class="accordion-body ms-5 pt-0">
                                    <p class="mb-0">Our app allows you to search for coupons by merchant name or
                                        category. Simply use the
                                        search bar at the top of the app to find relevant deals.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion mb-3" id="accordionExample5">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingfive">
                                <button class="accordion-button gap-4 align-items-start fw-bold collapsed" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapsefive" aria-expanded="true"
                                    aria-controls="collapsefive">
                                    <img class="icon-plus img-fluid" src="{{ asset('/images/plus-icon.png')}}" alt="">
                                    <img class="icon-minus img-fluid" src="{{ asset('/images/minus-icon.png')}}" alt="">
                                    How do I get {{$brands_offers[0]->brand_name}} cashback?
                                </button>
                            </h2>
                            <div id="collapsefive" class="accordion-collapse collapse "
                                aria-labelledby="headingfive" data-bs-parent="#accordionExample5">
                                <div class="accordion-body ms-5 pt-0">
                                    <p class="mb-0">Our app allows you to search for coupons by merchant name or
                                        category. Simply use the
                                        search bar at the top of the app to find relevant deals.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion mb-3" id="accordionExample6">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingsix">
                                <button class="accordion-button gap-4 align-items-start fw-bold collapsed" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapsesix" aria-expanded="true"
                                    aria-controls="collapsesix">
                                    <img class="icon-plus img-fluid" src="{{ asset('/images/plus-icon.png')}}" alt="">
                                    <img class="icon-minus img-fluid" src="{{ asset('/images/minus-icon.png')}}" alt="">
                                    Can I use 2 codes in {{$brands_offers[0]->brand_name}}?
                                </button>
                            </h2>
                            <div id="collapsesix" class="accordion-collapse collapse " aria-labelledby="headingsix"
                                data-bs-parent="#accordionExample6">
                                <div class="accordion-body ms-5 pt-0">
                                    <p class="mb-0">Our app allows you to search for coupons by merchant name or
                                        category. Simply use the
                                        search bar at the top of the app to find relevant deals.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion mb-3" id="accordionExample7">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingsix">
                                <button class="accordion-button gap-4 align-items-start fw-bold collapsed" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapsesixk" aria-expanded="true"
                                    aria-controls="collapsesix">
                                    <img class="icon-plus img-fluid" src="{{ asset('/images/plus-icon.png')}}" alt="">
                                    <img class="icon-minus img-fluid" src="{{ asset('/images/minus-icon.png')}}" alt="">
                                    Does {{$brands_offers[0]->brand_name}} have any valid coupon in {{$brands_offers[0]->country_name}} right now?
                                </button>
                            </h2>
                            <div id="collapsesixk" class="accordion-collapse collapse " aria-labelledby="headingsix"
                                data-bs-parent="#accordionExample7">
                                <div class="accordion-body ms-5 pt-0">
                                    <p class="mb-0">Our app allows you to search for coupons by merchant name or
                                        category. Simply use the
                                        search bar at the top of the app to find relevant deals.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion mb-3" id="accordionExample8">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingsix">
                                <button class="accordion-button gap-4 align-items-start fw-bold collapsed" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapsesixo" aria-expanded="true"
                                    aria-controls="collapsesix">
                                    <img class="icon-plus img-fluid" src="{{ asset('/images/plus-icon.png')}}" alt="">
                                    <img class="icon-minus img-fluid" src="{{ asset('/images/minus-icon.png')}}" alt="">
                                    How do I get a {{$brands_offers[0]->brand_name}} promo code or coupon voucher for {{$brands_offers[0]->country_name}}?
                                </button>
                            </h2>
                            <div id="collapsesixo" class="accordion-collapse collapse " aria-labelledby="headingsix"
                                data-bs-parent="#accordionExample8">
                                <div class="accordion-body ms-5 pt-0">
                                    <p class="mb-0">Our app allows you to search for coupons by merchant name or
                                        category. Simply use the
                                        search bar at the top of the app to find relevant deals.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion mb-3" id="accordionExample9">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingsixq">
                                <button class="accordion-button gap-4 align-items-start fw-bold collapsed" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapsesixq" aria-expanded="true"
                                    aria-controls="collapsesix">
                                    <img class="icon-plus img-fluid" src="{{ asset('/images/plus-icon.png')}}" alt="">
                                    <img class="icon-minus img-fluid" src="{{ asset('/images/minus-icon.png')}}" alt="">
                                    How to find the best deal on {{$brands_offers[0]->brand_name}} for {{$brands_offers[0]->country_name}}?
                                </button>
                            </h2>
                            <div id="collapsesixq" class="accordion-collapse collapse " aria-labelledby="headingsix"
                                data-bs-parent="#accordionExample9">
                                <div class="accordion-body ms-5 pt-0">
                                    <p class="mb-0">Our app allows you to search for coupons by merchant name or
                                        category. Simply use the
                                        search bar at the top of the app to find relevant deals.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion mb-3" id="accordionExample10">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingsix">
                                <button class="accordion-button gap-4 align-items-start fw-bold collapsed" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapsesixs" aria-expanded="true"
                                    aria-controls="collapsesix">
                                    <img class="icon-plus img-fluid" src="{{ asset('/images/plus-icon.png')}}" alt="">
                                    <img class="icon-minus img-fluid" src="{{ asset('/images/minus-icon.png')}}" alt="">
                                    How do I use {{$brands_offers[0]->brand_name}} coupon code for {{$brands_offers[0]->country_name}}?
                                </button>
                            </h2>
                            <div id="collapsesixs" class="accordion-collapse collapse " aria-labelledby="headingsix"
                                data-bs-parent="#accordionExample10">
                                <div class="accordion-body ms-5 pt-0">
                                    <p class="mb-0">Our app allows you to search for coupons by merchant name or
                                        category. Simply use the
                                        search bar at the top of the app to find relevant deals.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                     <div class="text-center">
                         <button id="viewAllButton" class="mbl-view-faq">View all</button>
                         <button id="hideAllButton" class="mbl-view-faq" style="display: none;">Hide all</button>
                    </div>

                    </div>
                    
            </div>
            </div>
        </div>

    </section>
    <!-- Accordion End -->
    </section>

<!-- orginal code -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
    const allItems = document.querySelectorAll(".accordion-item");
    const viewAllButton = document.getElementById("viewAllButton");
    const hideAllButton = document.getElementById("hideAllButton");

    // State to track whether items are manually expanded
    let isManuallyExpanded = false;

    // Function to update visibility based on screen size
    function updateVisibility() {
        if (window.innerWidth <= 768 && !isManuallyExpanded) { // Mobile view: width <= 768px
            // Initially, show only first 3 items
            allItems.forEach((item, index) => {
                if (index > 2) {
                    item.style.display = "none"; // Hide items after the first 3
                }
            });
            viewAllButton.style.display = "inline-block"; // Show "View All" button
            hideAllButton.style.display = "none"; // Hide "Hide All" button initially
        } else {
            // On larger screens (desktop), show all items
            allItems.forEach((item) => {
                item.style.display = "block"; // Show all items
            });
            viewAllButton.style.display = "none"; // Hide "View All" button
            hideAllButton.style.display = "none"; // Hide "Hide All" button
        }
    }

    // "View All" button click event: Show all items
    viewAllButton.addEventListener("click", function () {
        allItems.forEach((item) => {
            item.style.display = "block"; // Show all items
        });
        viewAllButton.style.display = "none"; // Hide "View All" button
        hideAllButton.style.display = "inline-block"; // Show "Hide All" button
        isManuallyExpanded = true; // Items are now manually expanded
    });

    // "Hide All" button click event: Hide items after the first 3
    hideAllButton.addEventListener("click", function () {
        allItems.forEach((item, index) => {
            if (index > 2) {
                item.style.display = "none"; // Hide items after the first 3
            }
        });
        viewAllButton.style.display = "inline-block"; // Show "View All" button
        hideAllButton.style.display = "none"; // Hide "Hide All" button
        isManuallyExpanded = false; // Reset manual expansion state
    });

    // Run updateVisibility on page load and on window resize
    updateVisibility();
    
    // Disable hiding on resize if manually expanded
    window.addEventListener("resize", function () {
        if (!isManuallyExpanded) {
            updateVisibility();
        }
    });
});

</script>