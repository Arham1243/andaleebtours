<script>
    const GlobalSearch = createApp({
        setup() {
            const tripType = ref('one-way');

            return {
                tripType,
            };
        },
    });
    GlobalSearch.mount('#global-search');
</script>
