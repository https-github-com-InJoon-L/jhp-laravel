<template>
    <div class="mx-auto justify-center lg:flex no-wrap ">
        <h2 class="card-title px-4"> 일주일 현황
            <div class="badge mx-2 badge-secondary">NEW</div>
        </h2>
        <line-chart v-if="loaded && (attend!=0 || late != 0 || absence !=0)" :height="300" :chart-data="count" :chart-labels="date"
            :options="options" />

        <div v-else class="alert alert-warning">
            <div class="flex-1">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    class="w-6 h-6 mx-2 stroke-current">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                    </path>
                </svg>
                <label>출석정보 없음</label>
            </div>
        </div>

        <h2 class="card-title px-4"> 한달 현황
            <div class="badge mx-2 badge-secondary">NEW</div>
        </h2>
        <line-chart v-if="loaded && monthRanking[0]" :height="300" :chart-data="count2" :chart-labels="date"
            :options="options" />
          <div v-else class="alert alert-warning">
            <div class="flex-1">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    class="w-6 h-6 mx-2 stroke-current">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                    </path>
                </svg>
                <label>출석정보 없음</label>
            </div>
        </div>
    </div>
</template>
<script>
    // import the styles 
    import LineChart from './DonutChart.vue'
    import 'chartjs-plugin-labels';
    export default {
        data: () => ({
            loaded: false,
            ranking: [],
            monthRanking: [],
            arr: [],
            late: 0,
            absence: 0,
            attend: 0,
            monthLate: 0,
            monthAbsence: 0,
            monthAttend: 0,
            date: '',
            count: '',
            chartdata: null,
            sum: 0,
            user_id: document.head.querySelector('meta[name="user-id"]').content,
            options: {
                plugins: {
                    labels: [{
                        render: 'value',
                        fontColor: ['white', 'white', 'white'],
                        precision: 5,
                        fontSize: 30,
                    }]

                },
                maintainAspectRatio: false,
                responsive: true,

            }

        }),
        components: {
            LineChart
        },

        mounted() {
            axios.get(`/api/user/${this.user_id}/attend/week`)
                .then(response => {
                    this.ranking = response.data.data
                    this.ranking.map(element => {
                        if (element.desc_value == "지각") {
                            ++this.late;
                        } else if (element.desc_value == '결석') {
                            ++this.absence;
                        } else if (element.desc_value == "출석") {
                            ++this.attend;
                        }
                    })
                    this.count = [this.attend, this.late, this.absence]


                    axios.get(`/api/user/${this.user_id}/attend/month`)
                        .then(response => {
                            this.monthRanking = response.data.data
                            console.log(this.monthRanking)
                            this.monthRanking.map(element => {
                                if (element.desc_value == "지각") {
                                    this.monthLate = element.count;
                                } else if (element.desc_value == '결석') {
                                    this.monthAbsence = element.count;
                                } else if (element.desc_value == "출석") {
                                    this.monthAttend = element.count;
                                }
                            })
                            this.count2 = [this.monthAttend, this.monthLate, this.monthAbsence]
                            console.log(this.count2)
                            this.loaded = true
                        })
                    // this.options.scales.yAxes.ticks.max = 5;
                })


        },
        methods: {
            isMobile() {
                return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
            }
        },
    }
</script>
