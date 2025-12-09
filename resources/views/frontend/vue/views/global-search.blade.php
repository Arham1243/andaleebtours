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
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="global-search-content tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                            aria-labelledby="pills-home-tab" tabindex="0">
                            <div class="d-flex align-items-center gap-4">
                                <div class="radio-btn">
                                    <input v-model="tripType" type="radio" id="one-way" class="radio-btn__input"
                                        name="trip_type" value="one-way">
                                    <label class="radio-btn__label" for="one-way">One way</label>
                                </div>
                                <div class="radio-btn">
                                    <input v-model="tripType" type="radio" id="round-trip" class="radio-btn__input"
                                        name="trip_type" value="round-trip">
                                    <label class="radio-btn__label" for="round-trip">Round Trip</label>
                                </div>
                                <div class="radio-btn">
                                    <input v-model="tripType" type="radio" id="multi-city" class="radio-btn__input"
                                        name="trip_type" value="multi-city">
                                    <label class="radio-btn__label" for="multi-city">Multi-City</label>
                                </div>
                            </div>
                            <div class="search-options" v-if="tripType === 'multi-city'">
                                multi city
                            </div>
                            <div class="search-options" v-else>
                                <div class="search-options-wrapper">
                                    <div class="search-box search-border">
                                        <div class="search-box__label">
                                            From
                                        </div>
                                        <input type="text" class="search-box__input" value="Dubai DXB">
                                        <div class="search-box__label">
                                            [DXB) Dubai International Airport
                                        </div>
                                    </div>
                                    <div class="search-box search-border">
                                        <div class="search-box__label">
                                            From
                                        </div>
                                        <input type="text" class="search-box__input" value="Dubai DXB">
                                        <div class="search-box__label">
                                            [DXB) Dubai International Airport
                                        </div>
                                    </div>
                                    <div class="search-button">
                                        <button class="themeBtn themeBtn--primary">Search</button>
                                    </div>
                                </div>
                                <div class="radio-btn">
                                    <input type="checkbox" id="direct-flights" class="radio-btn__input"
                                        name="is_direct_flight" value="true">
                                    <label class="radio-btn__label" for="direct-flights">Direct Flights</label>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                            aria-labelledby="pills-profile-tab" tabindex="0">2</div>
                        <div class="tab-pane fade" id="pills-contact" role="tabpanel"
                            aria-labelledby="pills-contact-tab" tabindex="0">3</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
