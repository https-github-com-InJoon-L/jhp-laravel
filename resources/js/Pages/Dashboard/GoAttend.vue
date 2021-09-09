<template>
    <!-- component -->
    <div class="flex justify-center btn-group" >
                <a class="btn btn-outline"  :href="route('free')">
                <i class="fas fa-clipboard"></i>
                <span>자유게시판</span>
                </a>
                <a class="btn btn-outline" :href="route('attend')">
                <i class="fas fa-check"></i>
                <span>출석</span>
                </a>
                                <a class="btn btn-outline"  :href="route('runauth')">
                <i class="fas fa-running"></i>
                <span>달리기 인증</span>
                </a>
                </div>

</template>

<script>
    // import the styles 
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
            user_id: document.head.querySelector('meta[name="user-id"]').content,
            user_photo: document.head.querySelector('meta[name="user-photo"]').content,
            user_name: document.head.querySelector('meta[name="user-name"]').content,
            user_sid: document.head.querySelector('meta[name="user-sid"]').content,
        }),
        components: {
            BadgeRed,
            BadgeGreen,
            BadgeYellow,
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




        },
        methods: {
            isMobile() {
                return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
            }
        },
    }
</script>
