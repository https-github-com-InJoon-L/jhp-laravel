<template>
    <div>
        <modal :show="show" :max-width="maxWidth" :closeable="closeable" @errorClose="errorClose">
            <div class="px-3 py-4">
                <div class="text-lg">
                    <slot name="title">
                    </slot>
                </div>
                <div class="mt-4">
                    <slot name="content">
                        오류입니다
                    </slot>
                </div>
            </div>
            <div class="px-6 py-4 bg-gray-100 text-right">
                <slot name="footer">
                    <jet-button  @click.prevent="close" :disabled="waiting" class="mr-3">
                        Close
                    </jet-button>
                    <jet-button @click.prevent="change" :disabled="waiting">
                        Save
                    </jet-button>
                </slot>
            </div>
        </modal>
    </div>
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
                default: 'xl'
            },
            closeable: {
                default: true
            },
        },
        data(){
            return{
            }
        },
        methods: {
            errorClose() {
                console.log('에러창 닫기');
                this.$emit('errorClose');
            },
        },
    }
</script>