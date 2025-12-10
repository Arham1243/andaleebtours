@include('frontend.vue.services.global-search')
<div class="global-search">
    <div class="container">
        <div id="pills-tab" role="tablist">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <ul class="search-pills-wrapper">
                        <li role="presentation">
                            <button class="search-pill active" id="pills-home-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                                aria-selected="true">Flight</button>
                        </li>
                        <li>
                            <a href="#" class="search-pill">Holidays</a>
                        </li>
                        <li role="presentation">
                            <button class="search-pill" id="pills-profile-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-profile" type="button" role="tab"
                                aria-controls="pills-profile" aria-selected="false">Hotels</button>
                        </li>
                        <li role="presentation">
                            <button class="search-pill" id="pills-contact-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-contact" type="button" role="tab"
                                aria-controls="pills-contact" aria-selected="false">Insurance</button>
                        </li>
                        <li>
                            <a href="#" class="search-pill">UAE Visa</a>
                        </li>
                        <li>
                            <a href="#" class="search-pill">UAE Visa Change</a>
                        </li>
                        <li>
                            <a href="#" class="search-pill">Offers</a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="global-search-content tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                            aria-labelledby="pills-home-tab" tabindex="0">
                            @include('frontend.vue.views.global-search.tabs.flights-search')
                        </div>
                        <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                            aria-labelledby="pills-profile-tab" tabindex="0">
                            @include('frontend.vue.views.global-search.tabs.hotels-search')
                        </div>
                        <div class="tab-pane fade" id="pills-contact" role="tabpanel"
                            aria-labelledby="pills-contact-tab" tabindex="0">
                            @include('frontend.vue.views.global-search.tabs.insurance-search')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
