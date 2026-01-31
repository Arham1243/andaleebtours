<script>
    const ActivitiesSearch = createApp({
        setup() {
            const activitySearchQuery = ref('');

            return {
                // Activities
                activitySearchQuery,
            };
        },
    });
    ActivitiesSearch.mount('#activities-search');
</script>
