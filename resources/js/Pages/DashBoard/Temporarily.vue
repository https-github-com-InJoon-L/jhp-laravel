<template>
    <div>
        <app-layout>
            <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Test DashBoard, 삭제 예정, 태그만 가져다 쓸 것
                </h2>
            </template>
            <div class="py-3">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 pt-3 shadow-md"
                        role="alert">
                            <TemporarilyDashBoardHead @changeTag="changeList"/>
                            <div>
                                <div class="flex flex-col">
                                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                                <table class="min-w-full divide-y divide-gray-200">
                                                    <thead class="bg-gray-50">
                                                        <tr class="justify-between flex">
                                                            <th scope="col" class="w-1/3 px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                                날짜
                                                            </th>
                                                            <th scope="col" class="w-1/3 px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                                바퀴 수
                                                            </th>
                                                            <th scope="col" class="w-1/3 px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                                결과
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <table v-if="ifLoading<2" class="flex items-center justify-center min-w-full bg-white">
                                                        <loading-bar />
                                                    </table>
                                                    <tbody v-if="tagIdx==1" class="bg-white divide-y divide-gray-200">
                                                        <TemporarilyDashBoard v-for="(atnd, idx) in selectedTag" :key="idx"
                                                        :attend="atnd"
                                                        />
                                                    </tbody>
                                                    <tbody v-else-if="tagIdx==2" class="bg-white divide-y divide-gray-200">
                                                        <TemporarilyDashBoard v-for="(atnd, idx) in allAttend.user_attend" :key="idx"
                                                        :attend="atnd"
                                                        />
                                                        <TemporarilyDashBoardRun v-for="(atnd, idx) in allAttend.user_run" :key="idx"
                                                        :attend="atnd.countRun" :msg="'현재 달려야하는 바퀴'"
                                                        />
                                                        <TemporarilyDashBoardRun v-for="(atnd, idx) in allAttend.user_run" :key="idx"
                                                        :attend="atnd.minusRun" :msg="'달린 바퀴'"
                                                        />
                                                        <TemporarilyDashBoardRun v-for="(atnd, idx) in allAttend.user_run" :key="idx"
                                                        :attend="atnd.totalRun" :msg="'총 달려야하는 바퀴'"
                                                        />
                                                    </tbody>
                                                </table>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </app-layout>
    </div>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import TemporarilyDashBoardHead from '@/Pages/DashBoard/TemporarilyDashBoardHead'
    import TemporarilyDashBoard from '@/Pages/DashBoard/TemporarilyDashBoard'
    import TemporarilyDashBoardRun from '@/Pages/DashBoard/TemporarilyDashBoardRun'
    import axios from 'axios'
    import LoadingBar from "@/Pages/Board/LoadingBar"
    

    export default {
        components: {
            AppLayout,
            TemporarilyDashBoardHead,
            TemporarilyDashBoard,
            TemporarilyDashBoardRun,
            LoadingBar,
        },
        data(){
            return{
                current_user_name:document.head.querySelector('meta[name="user-name"]').content,
                current_user_id:document.head.querySelector('meta[name="user-id"]').content,
                tagIdx:1,
                ifLoading:0,
                selectedTag:{},
                myAttend:{},
                allAttend:{},
            }
        },
        props: {
        },
        methods:{
            changeList(tagIdx){
                console.log('Nav Tag 변경',tagIdx);
                this.tagIdx=tagIdx;
                switch(tagIdx){
                    case 1:
                        this.selectedTag=this.myAttend;
                        break;
                    case 2:
                        break;
                    case 3:
                        break;
                    case 4:
                        break;
                }
            },
            visibleSelected(){
                if(this.ifLoading>=2){
                    this.selectedTag=this.myAttend;
                }
            }
        },
        mounted(){
            console.log(this.current_user);
            axios.get(`/api/user/attendance/${this.current_user_id}`)
                .then(res=>{
                    console.log('dancedancerevolution',res.data.attends);
                    this.myAttend=res.data.attends;
                    // this.selectedTag=this.myAttend;
                })
                .catch(err=>{
                    console.log(err);
                })
                .finally(()=>{
                    this.ifLoading+=1;
                    this.visibleSelected();
                })
            axios.get(`/api/user/attendStatus/${this.current_user_id}`)
                .then(res=>{
                    console.log('status',res.data.user_attend);
                    console.log('status',res.data.user_run);
                    this.allAttend=res.data;
                })
                .catch(err=>{
                    console.log(err);
                })
                .finally(()=>{
                    this.ifLoading+=1;
                    this.visibleSelected();
                })
                
        },
    }
</script>
