<form action="{{ route('frontend.uae-services') }}#tours" class="holidays-search-form" method="GET" v-cloak>
    <input type="text" name="search"class="holidays-search-form__input" placeholder="Search Activities" v-model="activitySearchQuery">
    <div class="search-button">
        <button :disabled="!activitySearchQuery" type="submit" class="themeBtn themeBtn--primary">Search</button>
    </div>
</form>