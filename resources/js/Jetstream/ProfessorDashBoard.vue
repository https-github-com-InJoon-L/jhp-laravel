<template>
    <!-- <div>
        <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2 border-b">
            <div class="p-6">
                <div class="flex items-center">
                    <svg v-if="user.current_team_id=='1'" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-red-400">
                        <path d="M12.075,10.812c1.358-0.853,2.242-2.507,2.242-4.037c0-2.181-1.795-4.618-4.198-4.618S5.921,4.594,5.921,6.775c0,1.53,0.884,3.185,2.242,4.037c-3.222,0.865-5.6,3.807-5.6,7.298c0,0.23,0.189,0.42,0.42,0.42h14.273c0.23,0,0.42-0.189,0.42-0.42C17.676,14.619,15.297,11.677,12.075,10.812 M6.761,6.775c0-2.162,1.773-3.778,3.358-3.778s3.359,1.616,3.359,3.778c0,2.162-1.774,3.778-3.359,3.778S6.761,8.937,6.761,6.775 M3.415,17.69c0.218-3.51,3.142-6.297,6.704-6.297c3.562,0,6.486,2.787,6.705,6.297H3.415z"></path>
					</svg>
                    <svg v-else fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-400">
                        <path d="M12.075,10.812c1.358-0.853,2.242-2.507,2.242-4.037c0-2.181-1.795-4.618-4.198-4.618S5.921,4.594,5.921,6.775c0,1.53,0.884,3.185,2.242,4.037c-3.222,0.865-5.6,3.807-5.6,7.298c0,0.23,0.189,0.42,0.42,0.42h14.273c0.23,0,0.42-0.189,0.42-0.42C17.676,14.619,15.297,11.677,12.075,10.812 M6.761,6.775c0-2.162,1.773-3.778,3.358-3.778s3.359,1.616,3.359,3.778c0,2.162-1.774,3.778-3.359,3.778S6.761,8.937,6.761,6.775 M3.415,17.69c0.218-3.51,3.142-6.297,6.704-6.297c3.562,0,6.486,2.787,6.705,6.297H3.415z"></path>
					</svg>
                    <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold">
                        <a href="#">
                        이름:{{user.name}}<br/>
                        학번:{{user.sid}}</a>
                    </div>
                </div>

                <div class="ml-12">
                    <div class="mt-2 text-sm text-gray-500">
                        {{user.email}}<br/>
                        {{user.class_team}}<br/>
                        {{user.current_team_id}}<br/>
                    </div>
                    <a @click="open">
                        <div class="mt-3 flex items-center text-sm font-semibold text-indigo-700">
                            <div>수정하기</div>

                            <div class="ml-1 text-indigo-500">
                                <svg viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div> -->
        <tr class="flex">
            <td class=" w-1/3 px-6 py-4 whitespace-nowrap text-center">
                <div class="max-w-max min-w-max text-center inline">
                    <span v-if="user.name" class="text-sm text-center text-gray-900">
                        {{user.name}}
                    </span>
                    <span v-else class="px-2 flex text-center inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                        등록된 이름 없음
                    </span>
                </div>
            </td>
            <td class="w-1/3 px-6 py-4 whitespace-nowrap text-center">
                <div class="max-w-max min-w-max text-center inline">
                    <span v-if="user.sid" class="text-sm text-center text-gray-900">
                        {{user.sid}}
                    </span>
                    <span v-else class="px-2 text-center inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                        등록된 학번 없음
                    </span>
                </div>
            </td>
            <td class="w-1/3 px-6 py-4 whitespace-nowrap text-right font-medium">
                <div class="max-w-max min-w-max text-center inline">
                    <a href="" @click="open" @click.prevent="openThread" class="text-sm text-indigo-600 hover:text-indigo-900 p-3">수정</a>
                </div>

            </td>
        </tr>
    <!-- </div> -->
</template>

<script>
    export default {
        components: {
        },
        props:{
            // id:String,
            // email:String,
            // std_name:String,
            // class_team:String,
            // sid:Number,
            // current_team_id:Number,
            // profile_photo_url:String
            user:Object,
        },
        data(){
            return{
                dialog:false,
            }
        },
        methods:{
            open() {
                console.log('사용자 정보 열람');
                this.$emit('open',this.user)
            },
        }
    }
</script>
