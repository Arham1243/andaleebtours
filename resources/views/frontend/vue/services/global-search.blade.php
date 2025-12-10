<script>
    const countriesDataPromise = fetch(
        "/frontend/mocks/yalago_countries.json"
    ).then((r) => r.json());
    const exactMatch = (arr, key, q) => {
        return arr.find((o) => {
            const value = o[key];
            return value && value.toLowerCase().trim() === q;
        });
    };

    const startsWith = (arr, key, q) =>
        arr.filter((o) => {
            const value = o[key];
            return value && value.toLowerCase().startsWith(q);
        });

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
