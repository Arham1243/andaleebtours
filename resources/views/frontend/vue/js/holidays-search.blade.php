<script>
    const GlobalSearch = createApp({
        setup() {
            const activitySearchQuery = ref('');

            return {
                // Holidays
                activitySearchQuery,
            };
        },
    });
    GlobalSearch.mount('#holidays-search');
</script>
