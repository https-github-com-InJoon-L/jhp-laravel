<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                출석현황
            </h2>
        </template>
        <div class="md:px-32 py-4 w-full">
         
<div class="overflow-hidden">
  <table class="table table-auto min-w-full table-zebra">
    <thead class="text-center">
      <tr>
        <th></th> 
        <th>상태</th> 
        <th>바퀴</th> 
        <th>시간</th>
      </tr>
    </thead> 
    <tbody>
      <tr  v-for="(attend,i) in attends" v-bind:key=i class="text-center justify-center">
        <th>{{i+1}}</th> 
        <td v-if="attend.desc_value=='출석'" class=" badge-success">{{ attend.desc_value }}</td> 
        <td v-else-if="attend.desc_value=='지각'" class=" badge-warning">{{ attend.desc_value }}</td> 
        <td v-else class="badge-error">{{ attend.desc_value }}</td> 
        <td>{{ attend.run }}</td> 
        <td>{{ attend.date }}</td>
      </tr>
    </tbody>
  </table>
</div>
        </div>

        <Dialog :show="dialogShow" @close="closeDialog">

            <template #title>
                {{ msg }}
            </template>

            <template #content>
                {{header}}
            </template>

            <template #footer>

                <jet-button type="button" class="ml-2">
                    <inertia-link :href="route('attend')"
                        class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">
                        확인</inertia-link>
                </jet-button>
            </template>
        </Dialog>

        <Dialog :show="showAttend" @close="closeDialog">

            <template #title>
                {{ msg }}
            </template>

            <template #content>
                {{header}}
                <br>
                {{header2}}
            </template>

            <template #footer>

                <jet-button type="button"
                    class="ml-2 bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded"
                    @click="closeDialog">
                    닫기
                </jet-button>

            </template>
        </Dialog>
    </app-layout>
</template>

<script>
    import Dialog from '@/Jetstream/DialogModal'
    import BadgeRed from '@/Geofencing/BadgeRed'
    import BadgeGreen from '@/Geofencing/BadgeGreen'
    import BadgeYellow from '@/Geofencing/BadgeYellow'
    import LoadingBar from "@/Pages/Board/LoadingBar"
    import AppLayout from '@/Layouts/AppLayout'
    export default {
        data: function () {
            return {
                header: '',
                header2: '',
                msg: '',
                user_name: document.head.querySelector('meta[name="user-name"]').content,
                user_sid: document.head.querySelector('meta[name="user-sid"]').content,
                user_class: document.head.querySelector('meta[name="user-class"]').content,
                user_photo: document.head.querySelector('meta[name="user-photo"]').content,
                user_id: document.head.querySelector('meta[name="user-id"]').content,
                csrf: document.head.querySelector('meta[name="csrf-token"]').content,
                dialogShow: false,
                attends: [],
                isLoading: 0,
                showAttend: false,
            }
        },
        components: {
            AppLayout,
            Dialog,
            BadgeRed,
            BadgeGreen,
            BadgeYellow,
            LoadingBar,
        },
        mounted() {

            axios.get('/api/user/attendStatus/' + this.user_id, null)
                .then(response => {
                    this.attends = response.data.user_attend;
                    this.isLoading = 1;
                    console.log(this.attends)
                })
                .catch(err => {
                    console.log(err);
                })
        },
        methods: {
            openDialog() {
                this.dialogShow = true;
            },
            closeDialog() {
                this.showAttend = false;
            },
            openAttendDialog(index) {
                this.msg = this.attends[index].desc_value;
                if (this.attends[index].run) {
                    this.header = this.attends[index].attend + " : [" + this.attends[index].desc_value + "]입니다";
                    this.header2 = " 지각 패널티 : " + this.attends[index].run + "바퀴 ";
                } else {
                    this.header = this.attends[index].attend + " : [" + this.attends[index].desc_value + "]입니다";
                    this.header2 = ''
                }
                this.showAttend = true;
            }
        }
    }
</script>
<style>
    jet-button {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
    }
</style>