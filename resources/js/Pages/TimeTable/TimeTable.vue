<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-primary leading-tight">
                시간표 (2학기)
            </h2>
        </template>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="shadow overflow-hidden rounded border-b border-primary-600">

                <div class="grid grid-cols-1 mt-5 mx-7">
                    <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">자바</label>
                    <select v-model="java"
                        class="py-2 px-3 rounded-lg border-2 border-purple-300 mt-1 focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                        <option selected="java">A반</option>
                        <option>B반</option>
                    </select>
                </div>

                <div class="grid grid-cols-1 mt-5 mx-7 mb-8">
                    <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">일본어</label>
                    <select v-model="japen"
                        class="py-2 px-3 rounded-lg border-2 border-purple-300 mt-1 focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                        <option>A반</option>
                        <option>B반</option>
                    </select>
                    <div v-if="!clicked">
                    <button @click="refresh()" class="btn min-w-full mt-4">불러오기</button>
                    </div>
                    <div v-else>
                        <span>시간표를 변경하실려면 새로고침 후 불러오기를 눌러주세요</span>
                    </div>
                </div>


                <table v-if="ifLoading<1" class=" flex items-center justify-center min-w-full bg-base">
                    <loading-bar />
                </table>
                <table v-else class="min-w-full table-auto overflow-x-auto">
                    <thead class="bg-primary-800 text-primary border-y-2 border-primary-600 ">
                        <tr class="border-b border-primary-600 text-primary">
                            <th
                                class="w-1/6 text-left py-3 font-semibold text-sm text-center border border-primary-600">
                            </th>
                            <th
                                class="w-1/6 text-left py-3 font-semibold text-sm text-center border border-primary-600">
                                월</th>
                            <th
                                class="w-1/6 text-left py-3 font-semibold text-sm text-center border border-primary-600">
                                화</th>
                            <th
                                class="w-1/6 text-left py-3 font-semibold text-sm text-center border border-primary-600">
                                수</th>
                            <th
                                class="w-1/6 text-left py-3 font-semibold text-sm text-center border border-primary-600">
                                목</th>
                            <th
                                class="w-1/6 text-left py-3 font-semibold text-sm text-center border border-primary-600">
                                금</th>
                        </tr>
                    </thead>
                    <tbody class="border-b">
                        <tr
                            class="w-1/6 text-left py-3 font-semibold text-sm text-center border-collapse border border-primary-600">
                            <td class=""> 9</td>
                            <template v-for="time in t9" v-bind:key="time">
                                <td :rowspan="time.EndTime- time.startHour"
                                    class="w-1/6 text-left py-3 font-semibold text-sm text-center text-primary-content">
                                    <span class="bg-red-500">{{ time.classTitle }} <br> {{ time.classPlace }}</span></td>
                            </template>
                        </tr>
                        <tr
                            class="w-1/6 text-left py-3 font-semibold text-sm text-center border-collapse border border-primary-600">
                            <td>10</td>
                            <template v-for="time in t10" v-bind:key="time">
                                <td :rowspan="time.EndTime- time.startHour"
                                    class="border-collapse border border-primary-600"><span class="bg-red-500">{{ time.classTitle }} <br> {{ time.classPlace }}</span></td>
                            </template>
                        </tr>
                        <tr
                            class="w-1/6 text-left py-3 font-semibold text-sm text-center border-collapse border border-primary-600">
                            <td class="">11</td>
                            <template v-for="time in t11" v-bind:key="time">
                                <td :rowspan="time.EndTime- time.startHour"
                                    class=" border-collapse border border-primary-600 text-primary-content">
                                    <span class="bg-red-400">{{ time.classTitle }} <br> {{ time.classPlace }}</span></td>
                            </template>
                        </tr>
                        <tr
                            class="w-1/6 text-left py-3 font-semibold text-sm text-center border-collapse border border-primary-600">
                            <td>12</td>
                            <template v-for="time in t12" v-bind:key="time">
                                <td :rowspan="(time.EndTime- time.startHour)"
                                    class="border-collapse border border-primary-600 text-primary-content">
                                    <span class="bg-blue-400">{{ time.classTitle }} <br> {{ time.classPlace }}</span></td>
                            </template>
                        </tr>
                        <tr
                            class="w-1/6 text-left py-3 font-semibold text-sm text-center border-collapse border border-primary-600">
                            <td>13</td>
                            <template v-for="time in t13" v-bind:key="time">
                                <td :rowspan="time.EndTime- time.startHour"
                                    class="border-collapse border border-primary-600"><span class="bg-primary-400">{{ time.classTitle }} <br> {{ time.classPlace }}</span></td>
                            </template>
                        </tr>
                        <tr
                            class="w-1/6 text-left py-3 font-semibold text-sm text-center border-collapse border border-primary-600">
                            <td>14</td>
                            <template v-for="time in t14" v-bind:key="time">
                                <td :rowspan="time.EndTime- time.startHour"
                                    class="border-collapse border border-primary-600 text-primary-content">
                                    <span class="bg-green-400">{{ time.classTitle }} <br> {{ time.classPlace }}</span></td>
                            </template>
                        </tr>
                        <tr
                            class="w-1/6 text-left py-3 font-semibold text-sm text-center border-collapse border border-primary-600">
                            <td>15</td>
                            <template v-for="time in t15" v-bind:key="time">
                                <td :rowspan="time.EndTime- time.startHour"
                                    class="border-collapse border border-primary-600 text-primary-content">
                                    <span class="bg-yellow-400">{{ time.classTitle }} <br> {{ time.classPlace }}</span></td>
                            </template>
                        </tr>
                        <tr
                            class="w-1/6 text-left py-3 font-semibold text-sm text-center border-collapse border border-primary-600 ">
                            <td>16</td>
                            <template v-for="time in t16" v-bind:key="time">
                                <td :rowspan="time.EndTime- time.startHour"
                                    class="border-collapse border border-primary-600 text-primary-content">
                                    <span class="bg-purple-400">{{ time.classTitle }} <br> {{ time.classPlace }}</span></td>
                            </template>
                        </tr>
                        <tr
                            class="w-1/6 text-left py-3 font-semibold text-sm text-center border-collapse border border-primary-600">
                            <td>17</td>
                            <template v-for="time in t17" v-bind:key="time">
                                <td :rowspan="time.EndTime- time.startHour"
                                    class="border-collapse border border-primary-600"><span class="bg-yellow-400">{{ time.classTitle }} <br> {{ time.classPlace }}</span></td>
                            </template>
                        </tr>
                        <tr
                            class="w-1/6 text-left py-3 font-semibold text-sm text-center border-collapse border border-primary-600 ">
                            <td>18</td>
                            <template v-for="time in t18" v-bind:key="time">
                                <td :rowspan="time.EndTime- time.startHour"
                                    class="border-collapse border border-primary-600 text-primary-content">
                                    <span class="bg-yellow-400">{{ time.classTitle }} <br> {{ time.classPlace }}</span></td>
                            </template>
                        </tr>
                        <tr
                            class="w-1/6 text-left py-3 font-semibold text-sm text-center border-collapse border border-primary-600">
                            <td>19</td>
                          
                        </tr>

                    </tbody>

                    <!--/ College Timetable
-->

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
            mon: [],
            tue: [],
            wed: [],
            tus: [],
            fri: [],
            times: [],
            t9 : [[],[],[],[],[]],
            t10 : [[],[],[],[],[]],
            t11 : [[],[],[],[],[]],
            t12 : [[]],
            t13 : [[],[],[],[],[]],
            t14 : [[],[],[],[],[]],
            t15 : [[]],
            t16 : [[]],
            t17 : [[],[],[],[],[]],
            t18 : [[],[],[],[],[]],
            java: 'A반',
            japen: 'A반',
            value1: 0,
            value2: 0,
            ifLoading: 1,
            clicked: '',
        }),
        computed: {

        },



        methods: {
            refresh() {
            this.ifLoading = 0;
            axios.get("api/timetables")
                .then(res => {
                    if (this.java == 'A반') {
                        this.value1 = 1;
                    } else {
                        this.value1 = 2;
                    }
                    if (this.japen == 'A반') {
                        this.value2 = 3;
                    } else {
                        this.value2 = 4;
                    }

                    if(this.japen == 'B반') {
                        if(this.java == 'B반') {
                            this.t12 = []
                        }
                    }
                    this.data = res.data.data;

                    this.data.sort(function (a, b) {
                        return a.day - b.day
                    })
                    this.data.forEach(element => {
                        if ((element.grade == 0 || element.grade == this.value1 || element.grade == this
                                .value2) && element.day == 0) {
                            this.mon.push(element)
                        }
                        if ((element.grade == 0 || element.grade == this.value1 || element.grade == this
                                .value2) && element.day == 1) {
                            this.tue.push(element)
                        }
                        if ((element.grade == 0 || element.grade == this.value1 || element.grade == this
                                .value2) && element.day == 2) {
                            this.wed.push(element)
                        }
                        if ((element.grade == 0 || element.grade == this.value1 || element.grade == this
                                .value2) && element.day == 3) {
                            this.tus.push(element)
                        }
                        if ((element.grade == 0 || element.grade == this.value1 || element.grade == this
                                .value2) && element.day == 4) {
                            this.fri.push(element)
                        }
                    })
                    this.mon.forEach(element => {
                        this.times.splice(element.startHour , 2, element);
                    })
                    this.tue.forEach(element => {
                        this.times.splice(element.startHour, 2, element);
                    })
                    this.wed.forEach(element => {
                        this.times.splice(element.startHour, 2, element);
                    })
                    this.tus.forEach(element => {
                        this.times.splice(element.startHour, 2, element);
                    })
                    this.fri.forEach(element => {
                        this.times.splice(element.startHour, 2, element);
                    })
                    this.times.sort(function (a, b) {
                        return a.day - b.day
                    })
                     this.times.forEach(element => {
                        if (element.startHour == 9) {
                            this.t9.splice(element.day, 2, element);
                        } else if (element.startHour == 10) {
                            this.t10.splice(element.day, 2, element);
                        } else if (element.startHour == 11) {
                            this.t11.splice(element.day, 2, element);
                        } else if (element.startHour == 12) {
                           this.t12.splice(element.day, 2, element);
                        } else if (element.startHour == 13) {
                            this.t13.splice(element.day, 2, element);;
                        } else if (element.startHour == 14) {
                            this.t14.splice(element.day, 2, element);
                        } else if (element.startHour == 15) {
                            this.t15.splice(element.day, 2, element);
                        } else if (element.startHour == 16) {
                            this.t16.splice(element.day, 2, element);
                        } else if (element.startHour == 17) {
                           this.t17.splice(element.day, 2, element);
                        } else if (element.startHour == 18) {
                            this.t18.splice(element.day, 2, element);
                        }
                    });
                    this.ifLoading = 1;
                    this.clicked = 1;
                })
            }
        },
    }
</script>
<style>
    a:hover {
        text-decoration: underline;
    }

    input:checked~.radio {
        color: white;
        background-color: green;
    }
</style>