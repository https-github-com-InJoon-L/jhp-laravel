<template>
    <modal :show="show" :max-width="maxWidth" :closeable="closeable" @close="close">
        <form @submit.prevent="saveClose">
            <div class="px-3 py-4">
                <div class="text-lg">
                    <slot name="title">
                    </slot>
                </div>
                <div class="mt-4">
                    <slot name="content">
                        <svg v-if="user.current_team_id=='1'" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-red-400">
                            <path d="M12.075,10.812c1.358-0.853,2.242-2.507,2.242-4.037c0-2.181-1.795-4.618-4.198-4.618S5.921,4.594,5.921,6.775c0,1.53,0.884,3.185,2.242,4.037c-3.222,0.865-5.6,3.807-5.6,7.298c0,0.23,0.189,0.42,0.42,0.42h14.273c0.23,0,0.42-0.189,0.42-0.42C17.676,14.619,15.297,11.677,12.075,10.812 M6.761,6.775c0-2.162,1.773-3.778,3.358-3.778s3.359,1.616,3.359,3.778c0,2.162-1.774,3.778-3.359,3.778S6.761,8.937,6.761,6.775 M3.415,17.69c0.218-3.51,3.142-6.297,6.704-6.297c3.562,0,6.486,2.787,6.705,6.297H3.415z"></path>
                        </svg>
                        <svg v-else fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-400">
                            <path d="M12.075,10.812c1.358-0.853,2.242-2.507,2.242-4.037c0-2.181-1.795-4.618-4.198-4.618S5.921,4.594,5.921,6.775c0,1.53,0.884,3.185,2.242,4.037c-3.222,0.865-5.6,3.807-5.6,7.298c0,0.23,0.189,0.42,0.42,0.42h14.273c0.23,0,0.42-0.189,0.42-0.42C17.676,14.619,15.297,11.677,12.075,10.812 M6.761,6.775c0-2.162,1.773-3.778,3.358-3.778s3.359,1.616,3.359,3.778c0,2.162-1.774,3.778-3.359,3.778S6.761,8.937,6.761,6.775 M3.415,17.69c0.218-3.51,3.142-6.297,6.704-6.297c3.562,0,6.486,2.787,6.705,6.297H3.415z"></path>
                        </svg>
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label for="name" value="Name" />
                            <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" autocomplete="name" placeholder="박 성철"/>
                            <jet-input-error :message="form.errors.name" class="mt-2" />
                        </div>
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label for="email" value="Email" />
                            <jet-input id="email" type="email" class="mt-1 block w-full" v-model="form.email" autocomplete="email" placeholder="scpark@g.yju.ac.kr"/>
                            <jet-input-error :message="form.errors.email" class="mt-2" />
                        </div>
                        <div class="flex flex-col mb-4">
                            <jet-label for="sid" value="Sid" />
                            <jet-input id="sid" type="number" class="mt-1 block w-full" v-model="form.sid" autocomplete="sid" placeholder="18-000000"/>
                            <jet-input-error :message="form.errors.sid" class="mt-2" />
                        </div>
                        <div class="flex flex-col mb-4">
                            <jet-label for="current_team_id" value="Class" />
                            <label v-for="(cname, idx) in classname" :key="idx">
                                <input v-if="(idx+1)==user.current_team_id" type='radio' name='class' :value="idx+1" checked>
                                <input v-else type='radio' name='class' :value="idx+1">
                                {{cname}}
                            </label>
                        </div>
                    </slot>
                </div>
            </div>
            <div class="px-6 py-4 bg-gray-100 text-right">
                <slot name="footer">
                    <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                        Saved.
                    </jet-action-message>

                    <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Save
                    </jet-button>
                </slot>
            </div>
        </form>
    </modal>
</template>

<script>
    import Modal from './Modal'
    import JetInput from '@/Jetstream/Input'
    import JetInputError from '@/Jetstream/InputError'
    import JetLabel from '@/Jetstream/Label'
    import JetActionMessage from '@/Jetstream/ActionMessage'
    import JetButton from './Button'

    export default {
        emits: ['close'],
        components: {
            Modal,
            JetButton,
            JetInput,
            JetInputError,
            JetLabel,
            JetActionMessage,
        },
        props: {
            show: {
                default: false
            },
            maxWidth: {
                default: '2xl'
            },
            closeable: {
                default: true
            },
            user:Object,
            form:Object,
        },
        data(){
            return{
                classname:[
                    '미등록 사용자',
                    'WDJ',
                    'CPJ',
                    '교수',
                ],
            }
        },
        methods: {
            close() {
                console.log('상세창 닫기');
                this.$emit('close');
            },
            saveClose(){
                console.log('저장 후 닫기');
                let checked = document.querySelector('input[name="class"]:checked');
                console.log(checked.value);
                if(!(checked&&(checked.value>=1&&checked.value<5))){
                    console.log('비정상적인 접근 1번으로 대체함');
                    document.querySelector('input[name="class"]').checked=true;
                    checked=document.querySelector('input[name="class"]:checked');
                }
                this.form.current_team_id=checked.value;
                this.form.patch('/api/user/'+this.user.id,{
                    onSuccess: () => this.$emit('close'),
                    onError: () => {
                        console.log('다시 입력하세요');
                    }
                });
                
            }
        }
    }
</script>
