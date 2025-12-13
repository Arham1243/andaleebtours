@include('frontend.vue.services.hotels-search')
<script>
    const HotelSearch = createApp({
        setup() {


               function useDropdown() {
                const open = ref(false);
                const wrapper = ref(null);

                const toggle = () => {
                    open.value = !open.value;
                };
                const close = () => {
                    open.value = false;
                };

                const onClickOutside = (e) => {
                    if (wrapper.value && !wrapper.value.contains(e.target)) {
                        close();
                    }
                };

                onMounted(() => {
                    document.addEventListener("click", onClickOutside);
                });

                onBeforeUnmount(() => {
                    document.removeEventListener("click", onClickOutside);
                });
                return {
                    open,
                    wrapper,
                    toggle,
                    close
                };
            }

            // Hotel Search Logic
            const hotelCheckInDate = ref(null);
            const hotelCheckOutDate = ref(null);
            const hotelRoomCount = ref(1);
            const hotelRooms = ref([{
                adults: 1,
                children: 0,
                childAges: []
            }]);

            const {
                open: hotelRoomsOpen,
                wrapper: hotelRoomsRef,
                toggle: toggleHotelRooms
            } = useDropdown();

            const {
                open: hotelDestinationDropdownOpen,
                wrapper: hotelDestinationWrapperRef,
                toggle: toggleHotelDestinationDropdown
            } = useDropdown();

            const hotelDestinationQuery = ref('');
            const hotelDestinationInputValue = ref('');
            const selectedHotelDestination = ref('');
            const hotelDestinations = ref({
                countries: [],
                provinces: [],
                locations: []
            });
            const hotelHotels = ref([]);
            const loadingHotelDestination = ref(false);

            const totalHotelGuestsText = computed(() => {
                const totalAdults = hotelRooms.value.reduce((sum, room) => sum + room.adults, 0);
                const totalChildren = hotelRooms.value.reduce((sum, room) => sum + room.children, 0);
                const totalGuests = totalAdults + totalChildren;
                const roomText = hotelRoomCount.value === 1 ? '1 Room' :
                `${hotelRoomCount.value} Rooms`;
                const guestText = totalGuests === 1 ? '1 Guest' : `${totalGuests} Guests`;
                return `${roomText}, ${guestText}`;
            });

            const hotelDestinationInputRef = ref(null);
            const onHotelDestinationBoxClick = () => {
                toggleHotelDestinationDropdown();
                hotelDestinationInputRef.value?.focus();
            };

            const loadHotelDestinations = async (searchQuery = '') => {
                loadingHotelDestination.value = true;
                try {
                    const data = await window.HotelGlobalSearchAPI(searchQuery);
                    hotelDestinations.value = data.destinations;
                    hotelHotels.value = data.hotels?.hotels || [];
                } catch (err) {
                    console.error("Hotel API Error:", err);
                    hotelDestinations.value = {
                        countries: [],
                        provinces: [],
                        locations: []
                    };
                    hotelHotels.value = [];
                } finally {
                    loadingHotelDestination.value = false;
                }
            };

            const selectHotelDestination = (destination) => {
                selectedHotelDestination.value = destination;
                hotelDestinationInputValue.value = destination;
                hotelDestinationQuery.value = '';
                toggleHotelDestinationDropdown();
            };

            watch(hotelDestinationQuery, (newQuery) => {
                loadHotelDestinations(newQuery);
            });

            // Watch room count changes
            watch(hotelRoomCount, (newCount, oldCount) => {
                if (newCount > oldCount) {
                    for (let i = oldCount; i < newCount; i++) {
                        hotelRooms.value.push({
                            adults: 1,
                            children: 0,
                            childAges: []
                        });
                    }
                } else if (newCount < oldCount) {
                    hotelRooms.value.splice(newCount);
                }
            });

            const incrementHotelGuests = (roomIndex, key) => {
                hotelRooms.value[roomIndex][key]++;
            };

            const decrementHotelGuests = (roomIndex, key) => {
                if (hotelRooms.value[roomIndex][key] > 0) {
                    if (key === 'adults' && hotelRooms.value[roomIndex][key] === 1) return;
                    hotelRooms.value[roomIndex][key]--;
                }
            };

            // Watch for children count changes in all rooms dynamically
            watch(() => hotelRooms.value.map(room => room.children), (newCounts, oldCounts) => {
                newCounts.forEach((newCount, roomIndex) => {
                    const oldCount = oldCounts[roomIndex] || 0;
                    if (newCount > oldCount) {
                        for (let i = oldCount; i < newCount; i++) {
                            hotelRooms.value[roomIndex].childAges.push('');
                        }
                    } else if (newCount < oldCount) {
                        hotelRooms.value[roomIndex].childAges.splice(newCount);
                    }
                });
            }, {
                deep: true
            });

            const isHotelSearchEnabled = computed(() => {
                const hasCheckIn = hotelCheckInDate.value && hotelCheckInDate.value.value !== '';
                const hasCheckOut = hotelCheckOutDate.value && hotelCheckOutDate.value.value !== '';
                const hasDestination = hotelDestinationInputValue.value && hotelDestinationInputValue
                    .value.trim() !== '';
                const hasRooms = hotelRooms.value.length > 0;

                // Check all rooms have at least 1 adult
                const allRoomsValid = hotelRooms.value.every(room => room.adults >= 1);

                // Check all child ages are filled
                const allChildAgesFilled = hotelRooms.value.every(room =>
                    room.childAges.length === room.children &&
                    room.childAges.every(age => age !== '')
                );

                return hasCheckIn && hasCheckOut && hasDestination && hasRooms && allRoomsValid &&
                    allChildAgesFilled;
            });

            return {
                // Hotel
                hotelCheckInDate,
                hotelCheckOutDate,
                hotelRoomCount,
                hotelRooms,
                hotelRoomsOpen,
                hotelRoomsRef,
                toggleHotelRooms,
                totalHotelGuestsText,
                incrementHotelGuests,
                decrementHotelGuests,
                hotelDestinationQuery,
                hotelDestinationInputValue,
                selectedHotelDestination,
                hotelDestinations,
                hotelHotels,
                loadingHotelDestination,
                hotelDestinationInputRef,
                onHotelDestinationBoxClick,
                selectHotelDestination,
                hotelDestinationDropdownOpen,
                hotelDestinationWrapperRef,
                toggleHotelDestinationDropdown,
                isHotelSearchEnabled
            };
        },
    });
    HotelSearch.mount('#hotels-search');
</script>
@push('css')
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/daterangepicker.css') }}" />
@endpush
@push('js')
    <script src="{{ asset('frontend/assets/js/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/assets/js/daterangepicker.min.js') }}"></script>
    <script>
        function initSingleDatePicker(wrapperId, inputId, dayDisplayId) {
            const format = "MMM D, YYYY";
            const $wrapper = $(`#${wrapperId}`);
            const $input = $(`#${inputId}`);
            const $dayDisplay = $(`#${dayDisplayId}`);

            if (!$wrapper.length || !$input.length || !$dayDisplay.length) return;

            // Initialize daterangepicker
            $input.daterangepicker({
                singleDatePicker: true,
                autoApply: true,
                showDropdowns: true,
                minDate: moment(),
                autoUpdateInput: false,
                locale: {
                    format
                }
            });

            $input.on("apply.daterangepicker", function(ev, picker) {
                $input.val(picker.startDate.format(format));
                $dayDisplay.text(picker.startDate.format("dddd"));
            });

            $wrapper.on("click", function(e) {
                if (!$(e.target).is($input)) {
                    const pickerInstance = $input.data('daterangepicker');
                    if (pickerInstance) {
                        pickerInstance.show();
                    }
                }
            });
        }


        $(document).ready(function() {
            initSingleDatePicker("hotel-checkin-box", "hotel-checkin-input", "hotel-checkin-day");
            initSingleDatePicker("hotel-checkout-box", "hotel-checkout-input", "hotel-checkout-day");
        });
    </script>
@endpush
