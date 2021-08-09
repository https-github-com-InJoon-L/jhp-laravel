<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                시간표
            </h2>
        </template>
        <div class="md:px-32 py-8 w-full">
            <div class="shadow overflow-hidden rounded border-b border-gray-200">
                <table v-if="ifLoading<1" class="flex items-center justify-center min-w-full bg-white">
                    <loading-bar />
                </table>
                <table v-else class="min-w-full bg-white">
                    <thead class="bg-gray-800 text-white">
                        <tr>
                            <th class="w-1/5 text-left py-3 font-semibold text-sm text-center">월</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        <tr v-for="(time,i) in times" v-bind:key="i">
                            <!-- 모바일  -->
                            <td v-if="time.day<1" class="w-1/5 text-left py-3 px-4 text-center "> {{ time.classTitle }}
                            </td>
                        </tr>
                    </tbody>

                                        <thead class="bg-gray-800 text-white">
                        <tr>
                            <th class="w-1/4 text-left py-3 font-semibold text-sm text-center">화</th>
                            <th class="w-1/4 text-left py-3 font-semibold text-sm text-center">화</th>
                            <th class="w-1/4 text-left py-3 font-semibold text-sm text-center">화</th>
                            <th class="w-1/4 text-left py-3 font-semibold text-sm text-center">화</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        <tr v-for="(time,i) in times" v-bind:key="i*2">
                            <!-- 모바일  -->
                            <td v-if="time.day >0 &&time.day<2" class="w-1/5 text-left py-3 px-4 text-center "> {{ time.classTitle }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import axios from 'axios'
    import cheerio from "cheerio"
    import LoadingBar from "@/Pages/Board/LoadingBar"
    export default {
        components: {
            AppLayout,
            LoadingBar,

        },
        data: () => ({
            times: [],
            ifLoading: 0,
        }),
        computed: {

        },
        mounted() {

            // 모바일이 아니면 실행될 코드 들어가는 곳
            axios.get("api/timetables")
                .then(res => {
                    this.times = (res.data.data);
                })
            this.ifLoading = 1;
        }



        ,
        methods: {},
    }
</script>
<style>
    a:hover {
        text-decoration: underline;
    }
</style>