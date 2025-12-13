<script>
    const countriesDataPromise = fetch(
        "{{ url('/') }}" + "/frontend/mocks/yalago_countries.json"
    ).then((r) => r.json());

    const formatCountries = (countries) => ({
        destinations: {
            countries
        },
    });

    window.InsuranceSearchAPI = async (qRaw) => {
        const q = qRaw.trim().toLowerCase();
        if (!q) return formatCountries([]);

        const countries = await countriesDataPromise;

        const cMatch = exactMatch(countries, "yalago_countries_title", q);
        if (cMatch) {
            return formatCountries([cMatch]);
        }

        const cs = startsWith(countries, "yalago_countries_title", q);
        return formatCountries(cs);
    };
</script>
