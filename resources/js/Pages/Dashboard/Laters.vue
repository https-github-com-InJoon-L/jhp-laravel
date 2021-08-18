<template>

    <div class="card lg:card-side bordered compact">
        <div class="card-body">
            <h2 class="card-title font-semibolds">지각 랭킹
                <div class="badge mx-2">WDJ</div>
            </h2>
            <div class="shadow overflow-auto rounded border-b border-primary-600">
                <table class="table table-auto min-w-full">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>이름</th>
                            <th>반</th>
                            <th>지각 수</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(rank,i) in ranking" v-bind:key=i>
                            <th>
                                <label>
                                    {{ i+1 }}
                                </label>
                            </th>
                            <td>
                                <div class="flex items-center space-x-2">
                                    <div class="avatar">
                                        <div class="w-12 h-12 mask mask-squircle">
                                            <img v-bind:src="rank.profile_photo_path" v-bind:alt="rank.name">
                                        </div>
                                    </div>
                                    <div>
                                        <div class="font-bold">
                                            {{ rank.name }}
                                        </div>
                                        <div class="text-sm opacity-50">
                                            {{ rank.sid }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-outline badge-sm">{{ rank.class }}</span>
                            </td>
                            <th class="text-center">
                            <progress class="progress progress-warning" v-bind:value="rank.total_count"
                                            v-bind:max="ranking[0].total_count"> </progress>
                                            <br>
                                            {{ rank.total_count }}
                            </th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</template>

<script>
    // import the styles 

    export default {
        data: () => ({
            ranking: [],
        }),
        components: {

        },
        mounted() {
            axios.get("/api/users/latecomers")
                .then(response => {
                    this.ranking = response.data.latecomers.wdj
                })



        },
        methods: {
            isMobile() {
                return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
            }
        },
    }
</script>
