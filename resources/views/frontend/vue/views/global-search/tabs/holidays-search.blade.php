<form class="holidays-search-form" method="GET" v-cloak>
    <input type="text" name="destination" class="holidays-search-form__input" placeholder="Search Activities" v-model="activitySearchQuery">
    <div class="search-button">
        <button :disabled="!activitySearchQuery" type="submit" class="themeBtn themeBtn--primary">Search</button>
    </div>
</form>