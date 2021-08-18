<template>

    <div class="card text-center shadow-2xl max-w-xs overflow-hidden mx-auto">
        <div class="card-body">
            <div class="bg-white rounded-lg py-3">
                <div class="avatar">

                    <div class="w-12 h-12 mask mask-squircle">
                        <img v-bind:src="user_photo" v-bind:alt="user_id">
                    </div>
                </div>
                <div class="card-title">
                    <h3 class="text-center text-xl text-gray-900 font-medium leading-8">{{ user_name }}</h3>
                    <div class="text-center text-gray-400 text-xs font-semibold">
                        <p>{{ user_sid }}</p>
                        <p> 총 바퀴 수 :{{ run.countRun }}</p>
                        <p v-if="run.minusRun>0"> 뛴 바퀴 수 :{{ run.minusRun }}</p>
                        <p v-else>안뜀 ㅎㅎ</p>
                        <p> 남은 바퀴 수 :{{ run.totalRun }}</p>
                    </div>
                  
                    <div class="text-center my-3">
                        <a class="text-xs text-indigo-500 italic hover:underline hover:text-indigo-600 font-medium"
                            href="#">더 보기</a>
                    </div>

                </div>
            </div>


        </div>
    </div>

</template>

<script>
    // import the styles 

    export default {
        data: () => ({
            ranking: [],
            run: [],
            user_id: document.head.querySelector('meta[name="user-id"]').content,
            user_photo: document.head.querySelector('meta[name="user-photo"]').content,
            user_name: document.head.querySelector('meta[name="user-name"]').content,
            user_sid: document.head.querySelector('meta[name="user-sid"]').content,
        }),
        components: {

        },
        mounted() {
            axios.get("/api/user/attendStatus/" + this.user_id)
                .then(response => {
                    this.ranking = response.data.user_attend
                    this.run = response.data.user_run[0]
                    console.log(this.run);
                })

                


        },
        methods: {
            isMobile() {
                return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
            }
        },
    }
</script>
