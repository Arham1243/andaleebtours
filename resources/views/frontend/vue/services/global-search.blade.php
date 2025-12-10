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



    const hotelsDataPromise = Promise.all([
        fetch('/frontend/mocks/yalago_countries.json').then(r => r.json()),
        fetch('/frontend/mocks/yalago_provinces.json').then(r => r.json()),
        fetch('/frontend/mocks/yalago_locations.json').then(r => r.json())
    ]).then(([countries, provinces, locations]) => ({
        countries,
        provinces,
        locations
    }));


    const byField = (arr, field, value) => arr.filter(o => o[field] === value);

    const formatHotels = ({
        countries,
        provinces,
        locations,
        hotels
    }) => ({
        destinations: {
            countries,
            provinces,
            locations
        },
        hotels: {
            hotels
        }
    });


    window.HotelGlobalSearchAPI = async qRaw => {
        const q = qRaw.trim().toLowerCase();
        if (!q) return formatHotels({
            countries: [],
            provinces: [],
            locations: [],
            hotels: []
        });
        const {
            countries,
            provinces,
            locations
        } = await hotelsDataPromise;

        // Exact country match
        const cMatch = exactMatch(countries, 'yalago_countries_title', q);
        if (cMatch) {
            const provs = byField(provinces, 'yalago_provinces_cid', cMatch.yalago_countries_id);
            provs.unshift({
                ...cMatch,
                yalago_provinces_title: cMatch.yalago_countries_title
            });
            return formatHotels({
                countries: [],
                provinces: provs,
                locations: [],
                hotels: []
            });
        }

        // Exact province match
        const pMatch = exactMatch(provinces, 'yalago_provinces_title', q);
        if (pMatch) {
            const locs = byField(locations, 'yalago_locations_pid', pMatch.yalago_provinces_id);
            locs.unshift({
                ...pMatch,
                yalago_locations_title: pMatch.yalago_provinces_title
            });
            return formatHotels({
                countries: [],
                provinces: [],
                locations: locs,
                hotels: []
            });
        }

        // Exact location match
        const lMatch = exactMatch(locations, 'yalago_locations_title', q);
        if (lMatch) {
            try {
                // TODO: add api call here
                return formatHotels({
                    countries: [],
                    provinces: [],
                    locations: [lMatch],
                    hotels: []
                });
            } catch (error) {
                console.error('Error fetching hotels:', error);
                return formatHotels({
                    countries: [],
                    provinces: [],
                    locations: [lMatch],
                    hotels: []
                });
            }
        }

        // Check for partial matches
        const cs = startsWith(countries, 'yalago_countries_title', q);
        const ps = startsWith(provinces, 'yalago_provinces_title', q);
        const ls = startsWith(locations, 'yalago_locations_title', q);

        // If no geo data matches, search hotels directly
        if (!cs.length && !ps.length && !ls.length) {
            try {
                const {
                    data
                } = await axios.get(`/hotels/ajax_search_hotels?q=${q}`);
                return formatHotels({
                    countries: [],
                    provinces: [],
                    locations: [],
                    hotels: data
                });
            } catch (error) {
                console.error('Error fetching hotels directly:', error);
                return formatHotels({
                    countries: [],
                    provinces: [],
                    locations: [],
                    hotels: []
                });
            }
        }

        return formatHotels({
            countries: cs,
            provinces: ps,
            locations: ls,
            hotels: []
        });
    };
</script>
