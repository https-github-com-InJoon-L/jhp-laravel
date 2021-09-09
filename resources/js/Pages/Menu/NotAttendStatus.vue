<template>
    <!-- component -->
    <div class=" flex-col  md:flex-row justify-center gap-3  ">
        <div class="min-w-full p-4">
            <div
                class=" bg-white max-w-full shadow-lg   mx-auto border-b-4 border-red-400 rounded-2xl overflow-hidden  hover:shadow-2xl transition duration-500 transform hover: cursor-pointer">
                <div class="bg-red-400  flex h-20  items-center">
                    <h1 class="text-white ml-4 border-2 py-2 px-4 rounded-full text-sm font-bold">{{ this.todayWithDay }}</h1>
                    <p class="ml-2 text-white uppercase text-sm">미출석자</p>
                </div>
                <div class="p-3 text-lg" v-if="attends[0]">
                  <VTextMarquee :speed="50" :content="text" class="text-primary"></VTextMarquee>
                </div>
                <div v-else class="flex justify-center p-3  gap-5 badge-error font-bold">미출석자 없음</div>
            </div>
        </div>


    </div>


</template>

<script>
    // import the styles 
    import { VTextMarquee } from 'vue-text-marquee';
    import BadgeRed from '@/Geofencing/BadgeRed'
    import BadgeGreen from '@/Geofencing/BadgeGreen'
    import BadgeYellow from '@/Geofencing/BadgeYellow'  
    export default {
        data: () => ({
            date: '',
            attend: 0,
            late: 0,
            absence: 0,
            attends: [],
            ranking: [],
            run: [],
            total: 0,
            laters: [],
            absencers: [],
            todayWithDay: '',
            text: [],
            user_id: document.head.querySelector('meta[name="user-id"]').content,
            user_photo: document.head.querySelector('meta[name="user-photo"]').content,
            user_name: document.head.querySelector('meta[name="user-name"]').content,
            user_sid: document.head.querySelector('meta[name="user-sid"]').content,
        }),
        components: {
            BadgeRed,
            BadgeGreen,
            BadgeYellow,
            VTextMarquee
        },
        mounted() {
            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
            var yyyy = today.getFullYear();
            var week = new Array('일요일', '월요일', '화요일', '수요일', '목요일', '금요일', '토요일');
            var day = today.getDay();
            var dayLabel = week[day];
            this.todayWithDay =  yyyy + '-' + mm + '-' + dd + " ("+dayLabel+")";
            this.date = yyyy + '-' + mm + '-' + dd;
              axios.get('/api/attends/not_users')
                .then(response => {
                    this.attends = response.data.not_users;
                    this.attends.forEach(element=>{
                        this.text.push(element.name +" ") 
                    })

                })




        },
        methods: {
            isMobile() {
                return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
            }
        },
    }
</script>
