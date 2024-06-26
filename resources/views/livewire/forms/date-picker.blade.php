<div x-data="{
    MONTH_NAMES: ['Januari', 'Februari', 'Mac', 'April', 'Mei', 'Jun', 'Julai', 'Ogos', 'September', 'Oktober', 'November', 'Disember'],
    DAYS: ['Ahad', 'Isn', 'Sel', 'Rabu', 'Kha', 'Jum', 'Sabt'],
    showDatepicker: false,
    datepickerValue: '',

    month: '',
    year: '',
    no_of_days: [],
    blankdays: [],
    days_full: ['Ahad', 'Isnin', 'Selasa', 'Rabu', 'Khamis', 'Jumaat', 'Sabtu'],

    initDate() {
        let today = new Date();

        this.month = today.getMonth();
        this.year = today.getFullYear();

        const selectedDate = new Date(this.year, this.month, today.getDate());
        const formattedDate = selectedDate.getDate() + ' ' + this.MONTH_NAMES[selectedDate.getMonth()] + ' ' + selectedDate.getFullYear()
        this.datepickerValue = formattedDate;
    },

    isToday(date) {
        const today = new Date();
        const d = new Date(this.year, this.month, date);

        return today.toDateString() === d.toDateString() ? true : false;
    },

    getDateValue(date) {
        let selectedDate = new Date(this.year, this.month, date);
        const formattedDate = selectedDate.getDate() + ' ' + this.MONTH_NAMES[selectedDate.getMonth()] + ' ' + selectedDate.getFullYear()

        this.datepickerValue = formattedDate;

        this.$refs.date.value = selectedDate.getFullYear() +'-'+ ('0'+ selectedDate.getMonth()).slice(-2) +'-'+ ('0' + selectedDate.getDate()).slice(-2);
        $wire.$parent.set('{{$name}}', this.$refs.date.value);

        console.log(this.$refs.date.value);

        this.showDatepicker = false;
    },

    getNoOfDays() {
        let daysInMonth = new Date(this.year, this.month + 1, 0).getDate();

        // find where to start calendar day of week
        let dayOfWeek = new Date(this.year, this.month).getDay();
        let blankdaysArray = [];
        for ( var i=1; i <= dayOfWeek; i++) {
            blankdaysArray.push(i);
        }

        let daysArray = [];
        for ( var i=1; i <= daysInMonth; i++) {
            daysArray.push(i);
        }

        this.blankdays = blankdaysArray;
        this.no_of_days = daysArray;

        // console.log($wire.$get('form.started_at'));
    }
}" x-init="[initDate(), getNoOfDays()]" x-cloak class="flex-1">
    <div class="relative">
        <input type="hidden" wire:model="$parent.{{$name}}" x-ref="date">
        <input
        type="text"
        readonly
        x-model="datepickerValue"
        @click="showDatepicker = !showDatepicker"
        @keydown.escape="showDatepicker = false"
        class="w-full h-12 py-3 pl-4 pr-10 font-medium leading-none text-gray-600 border border-gray-300 rounded-lg focus:outline-none focus:shadow-outline"
        placeholder="Select date">

        <div class="absolute top-0 right-0 px-3 py-2">
            <svg class="w-6 h-6 text-gray-400"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
        </div>

        <!-- <div x-text="no_of_days.length"></div>
        <div x-text="32 - new Date(year, month, 32).getDate()"></div>
        <div x-text="new Date(year, month).getDay()"></div> -->

        <div
            class="absolute top-0 left-0 p-4 mt-12 bg-white rounded-lg shadow w-96"
            x-show.transition="showDatepicker"
            @click.away="showDatepicker = false">

            <div class="flex items-center justify-between mb-2">
                <div>
                    <span x-text="MONTH_NAMES[month]" class="text-lg font-bold text-gray-800"></span>
                    <span x-text="year" class="ml-1 text-lg font-normal text-gray-600"></span>
                </div>
                <div>
                    <button
                        type="button"
                        class="inline-flex p-1 transition duration-100 ease-in-out rounded-full cursor-pointer hover:bg-gray-200"
                        {{-- :class="{'cursor-not-allowed opacity-25': month == 0 }"
                        :disabled="month == 0 ? true : false" --}}
                        @click="if (month == 0) {
                                    year--;
                                    month = 11;
                                } else
                                    month--;
                                getNoOfDays();
                        ">
                        <svg class="inline-flex w-6 h-6 text-gray-500"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </button>
                    <button
                        type="button"
                        class="inline-flex p-1 transition duration-100 ease-in-out rounded-full cursor-pointer hover:bg-gray-200"
                        {{-- :class="{'cursor-not-allowed opacity-25': month == 11 }" --}}
                        {{-- :disabled="month == 11 ? true : false" --}}
                        @click="if (month == 11) {
                                    year++;
                                    month = 0;
                                } else
                                    month++;
                                getNoOfDays();
                        ">
                        <svg class="inline-flex w-6 h-6 text-gray-500"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="flex flex-wrap mb-3 -mx-1">
                <template x-for="(day, index) in DAYS" :key="index">
                    <div style="width: 14.26%" class="">
                        <div
                            x-text="day"
                            class="text-xs font-medium text-center text-gray-800"></div>
                    </div>
                </template>
            </div>

            <div class="flex flex-wrap -mx-1">
                <template x-for="blankday in blankdays">
                    <div
                        style="width: 14.28%; height: 2rem;"
                        class="text-sm text-center border border-transparent"
                    ></div>
                </template>
                <template x-for="(date, dateIndex) in no_of_days" :key="dateIndex">
                    <div style="width: 14.28%; height: 2rem;" class="mb-1 ">
                        <div
                            @click="getDateValue(date)"
                            x-text="date"
                            class="flex items-center justify-center h-full text-sm leading-none leading-loose transition duration-100 ease-in-out rounded-full cursor-pointer"
                            :class="{'bg-blue-500 text-white': isToday(date) == true, 'text-gray-700 hover:bg-blue-200': isToday(date) == false }"
                        >
                        {{-- <span x-text="date"></span> --}}
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
</div>
