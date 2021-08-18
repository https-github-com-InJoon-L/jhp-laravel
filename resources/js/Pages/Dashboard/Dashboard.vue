<template>
    <app-layout>
        <template #header>
            <!-- Navigation Links -->
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    대시보드
                </h2>
            </div>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                                                 <LatersChart/>
                                                        <MyAttend/>
                    <most-runner/>
                    <laters/>
                    <abcenters/>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import Welcome from '@/Jetstream/Welcome'
    import JetNavLink from '@/Jetstream/NavLink'
    import MostRunner from "@/Pages/Dashboard/MostRunner"
    import Laters from "@/Pages/Dashboard/Laters"
    import Abcenters from '@/Pages/Dashboard/Abcenters'
    import MyAttend from '@/Pages/Dashboard/MyAttendStatus'
    import LatersChart from '@/Pages/Dashboard/LatersChart'
    export default {
        data: () => ({}),
        components: {
            AppLayout,
            Welcome,
            JetNavLink,
            MostRunner,
            Laters,
            Abcenters,
            MyAttend,
            LatersChart,

        },
         mounted() {
                axios.get("/api/users/runners")
                    .then(response => {
                        console.log(response.data);
                    }) 
            


        },
        methods: {
            isMobile() {
                return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
            }
        },
    }
</script>
