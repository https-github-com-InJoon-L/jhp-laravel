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
                                                        <tr class="justify-between flex">
                                                            <th scope="col" class="w-1/3 px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                                Name
                                                            </th>
                                                            <th scope="col" class="w-1/3 px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                                <span class="">Sid</span>
                                                            </th>
                                                            <th scope="col" class="w-1/3 px-6 py-3">
                                                                <span class="sr-only">Edit</span>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="bg-white divide-y divide-gray-200">
                                                        <professor-dash-board v-for="user in selectedTeam" :key="user.id"
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
        :user="selectedUser" @close="closeDialog">
        </professor-dialog>
        <professor-error-dialog :show="errorDialogShow" @close="closeErrorDialog">
        </professor-error-dialog>
    </div>
    
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import ProfessorDashBoardHead from '@/Jetstream/ProfessorDashBoardHead'
    import ProfessorDashBoard from '@/Jetstream/ProfessorDashBoard'
    import ProfessorDialog from '@/Jetstream/ProfessorDialog'
    import ProfessorErrorDialog from '@/Jetstream/ProfessorErrorDialog'
    import axios from 'axios'

    export default {
        components: {
            AppLayout,
            ProfessorDashBoardHead,
            ProfessorDashBoard,
            ProfessorDialog,
            ProfessorErrorDialog,
        },
        data(){
            return{
                dialogShow:false,
                errorDialogShow:false,
                selectedUser:{},
                backupUser:{
                    name:'',
                    email:'',
                    sid:'',
                    phone_number:'',
                    current_team_id:'',
                },
                selectedTeam:[],
                allTeam:[],
                form: this.$inertia.form({
                    _method: 'PATCH',
                    user:{},
                }),
            }
        },
        props: {
            users: Object,
        },
        methods:{
            closeDialog(state){
                console.log('클로즈 도착');
                if(state==1||state==3){
                    this.selectedUser.name = this.backupUser.name;
                    this.selectedUser.sid = this.backupUser.sid;
                    this.selectedUser.email = this.backupUser.email;
                    this.selectedUser.phone_number = this.backupUser.phone_number;
                    this.selectedUser.current_team_id = this.backupUser.current_team_id;
                    if(state==3){
                        this.errorDialogShow=true;
                        return;
                    }
                }else if(state==2){
                    for(let key in this.selectedTeam) {
                        if(this.selectedUser == this.selectedTeam[key]){
                            delete this.selectedTeam[key];
                            switch(this.selectedUser.current_team_id){
                                case "1":
                                    this.allTeam.none[key]=this.selectedUser;
                                    break;
                                case '2':
                                    this.allTeam.wdj[key]=this.selectedUser;
                                    break;
                                case '3':
                                    this.allTeam.cpj[key]=this.selectedUser;
                                    break;
                                case '4':
                                    this.allTeam.professor[key]=this.selectedUser;
                                    break;
                                default:
                                    loaction.reload();
                            }
                            break;
                        }
                    }
                }
                this.dialogShow=false;
            },
            openDialog(user){
                console.log('오픈 도착');
                this.selectedUser=user;
                this.backupUser.name=user.name;
                this.backupUser.sid=user.sid;
                this.backupUser.email=user.email;
                this.backupUser.phone_number=user.phone_number;
                this.backupUser.current_team_id=user.current_team_id;
                this.dialogShow=true;
            },
            closeErrorDialog(){
                console.log('error 발생');
                this.errorDialogShow=false;
            },
            changeList(tagIdx){
                console.log('Nav Tag 변경',tagIdx);
                switch(tagIdx){
                    case 1:
                        this.selectedTeam = this.allTeam.none;
                        break;
                    case 2:
                        this.selectedTeam = this.allTeam.wdj;
                        break;
                    case 3:
                        this.selectedTeam = this.allTeam.cpj;
                        break;
                    case 4:
                        this.selectedTeam = this.allTeam.professor;
                        break;
                }
            }
        },
        mounted(){
            axios.get('/api/users')
                .then(res=>{
                    console.log(res.data.status);
                    const classTeam = res.data.data;
                    this.allTeam = classTeam;
                    this.selectedTeam = classTeam.none;
                    // console.log(classTeam);
                    // console.log(classTeam.none);//1
                    // console.log(classTeam.wdj);//2
                    // console.log(classTeam.cpj);//3
                    // console.log(classTeam.professor);//4
                    // this.allTeam.wdj.forEach(element => console.log(element));
                })
                .catch(err=>{
                    console.log(err);
                })
            console.log(this.allTeam);
        },
    }
</script>
