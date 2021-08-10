<template>
    <div>
        <app-layout>
            <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    대시보드testing!!
                </h2>
            </template>

            <div class="py-3">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 pt-3 shadow-md"
                        role="alert">
                            <professor-dash-board-head @changeTag="changeList"/>
                            <div>
                                <div class="flex flex-col">
                                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                                <table class="min-w-full divide-y divide-gray-200">
                                                    <thead class="bg-gray-50">
                                                        <tr>
                                                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                                Name
                                                            </th>
                                                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                                Sid
                                                            </th>
                                                            <th scope="col" class="relative px-6 py-3">
                                                                <span class="sr-only">Edit</span>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="bg-white divide-y divide-gray-200">
                                                        <professor-dash-board v-for="user in users" :key="user.id"
                                                        :user="user"
                                                        @open="openDialog"
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
        <professor-dialog :show="dialogShow"
        :user="selectedUser" :form="form" @close="closeDialog">
        </professor-dialog>
        
    </div>
    
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import ProfessorDashBoardHead from '@/Jetstream/ProfessorDashBoardHead'
    import ProfessorDashBoard from '@/Jetstream/ProfessorDashBoard'
    import ProfessorDialog from '@/Jetstream/ProfessorDialog'

    import axios from 'axios'

    export default {
        components: {
            AppLayout,
            ProfessorDashBoardHead,
            ProfessorDashBoard,
            ProfessorDialog,
        },
        data(){
            return{
                dialogShow:false,
                selectedUser:{},
                teamFir:[],
                teamSec:[],
                teamThi:[],
                teamFou:[],
                form:{},
            }
        },
        
        props: {
            users: Object,
        },
        methods:{
            closeDialog(){
                console.log('클로즈 도착');
                this.dialogShow=false;
            },
            openDialog(user){
                console.log('오픈 도착');
                this.selectedUser=user;
                this.form=this.$inertia.form({
                    _method: 'POST',
                    name: this.selectedUser.name,
                    email: this.selectedUser.email,
                    sid: this.selectedUser.sid,
                    current_team_id: this.selectedUser.current_team_id,
                });
                this.dialogShow=true;
            },
            changeList(tagIdx){
                console.log('Nav Tag 변경',tagIdx);
            }
        },
        mounted(){
            console.log(this.users);
            axios.get('/api/users')
                .then(res=>{
                    console.log(res.data);
                })
                .catch(err=>{
                    console.log(err);
                })
        },
    }
</script>
