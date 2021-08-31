<template>
    <div>
        <modal
            :show="show"
            :max-width="maxWidth"
            :closeable="closeable"
            @close="close"
        >
            <form>
                <div class="px-3 py-4">
                    <div class="text-lg">
                        <slot name="title"> </slot>
                    </div>
                    <div class="mt-4">
                        <slot name="content">
                            <svg
                                v-if="user.current_team_id == '1'"
                                fill="none"
                                stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                                class="w-8 h-8 text-red-400"
                            >
                                <path
                                    d="M12.075,10.812c1.358-0.853,2.242-2.507,2.242-4.037c0-2.181-1.795-4.618-4.198-4.618S5.921,4.594,5.921,6.775c0,1.53,0.884,3.185,2.242,4.037c-3.222,0.865-5.6,3.807-5.6,7.298c0,0.23,0.189,0.42,0.42,0.42h14.273c0.23,0,0.42-0.189,0.42-0.42C17.676,14.619,15.297,11.677,12.075,10.812 M6.761,6.775c0-2.162,1.773-3.778,3.358-3.778s3.359,1.616,3.359,3.778c0,2.162-1.774,3.778-3.359,3.778S6.761,8.937,6.761,6.775 M3.415,17.69c0.218-3.51,3.142-6.297,6.704-6.297c3.562,0,6.486,2.787,6.705,6.297H3.415z"
                                ></path>
                            </svg>
                            <svg
                                v-else
                                fill="none"
                                stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                                class="w-8 h-8 text-gray-400"
                            >
                                <path
                                    d="M12.075,10.812c1.358-0.853,2.242-2.507,2.242-4.037c0-2.181-1.795-4.618-4.198-4.618S5.921,4.594,5.921,6.775c0,1.53,0.884,3.185,2.242,4.037c-3.222,0.865-5.6,3.807-5.6,7.298c0,0.23,0.189,0.42,0.42,0.42h14.273c0.23,0,0.42-0.189,0.42-0.42C17.676,14.619,15.297,11.677,12.075,10.812 M6.761,6.775c0-2.162,1.773-3.778,3.358-3.778s3.359,1.616,3.359,3.778c0,2.162-1.774,3.778-3.359,3.778S6.761,8.937,6.761,6.775 M3.415,17.69c0.218-3.51,3.142-6.297,6.704-6.297c3.562,0,6.486,2.787,6.705,6.297H3.415z"
                                ></path>
                            </svg>
                            <table
                                v-if="ifLoading < 1"
                                class="
                                    loading
                                    flex
                                    items-center
                                    justify-center
                                    min-h-full min-w-full
                                    bg-white
                                "
                            >
                                <loading-bar />
                            </table>
                            <div class="flex flex-col mb-4">
                                <jet-label for="name" value="상태" />
                                <jet-input
                                    id="name"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="attend.desc_value"
                                    autocomplete="name"
                                    placeholder="지각, 병결 등"
                                />
                            </div>
                            <div class="flex flex-col mb-4">
                                <jet-label for="name" value="바퀴" />
                                <jet-input
                                    id="name"
                                    type="number"
                                    class="mt-1 block w-full"
                                    v-model="attend.run"
                                    autocomplete="run"
                                    placeholder="현재와 같거나 0이어야 합니다."
                                />
                            </div>
                        </slot>
                    </div>
                </div>
                <div class="px-6 py-4 bg-gray-100 text-right">
                    <slot name="footer">
                        <jet-button
                            @click.prevent="close"
                            :disabled="waiting"
                            class="mr-3"
                        >
                            Close
                        </jet-button>
                        <jet-button @click.prevent="change" :disabled="waiting">
                            Save
                        </jet-button>
                    </slot>
                </div>
            </form>
        </modal>
    </div>
</template>

<script>
import Modal from "@/Jetstream/Modal";
import JetInput from "@/Jetstream/Input";
import JetInputError from "@/Jetstream/InputError";
import JetLabel from "@/Jetstream/Label";
import JetActionMessage from "@/Jetstream/ActionMessage";
import JetButton from "@/Jetstream/Button";
import LoadingBar from "@/Pages/Board/LoadingBar";
import axios from "axios";

export default {
    emits: ["attendChangeClose"],
    components: {
        Modal,
        JetButton,
        JetInput,
        JetInputError,
        JetLabel,
        JetActionMessage,
        LoadingBar,
    },
    props: {
        show: {
            default: false,
        },
        maxWidth: {
            default: "2xl",
        },
        closeable: {
            default: true,
        },
        user: Object,
        attend: Object,
        backupAttend: Object,
        ifLoading: {
            default: 1,
        },
    },
    data() {
        return {
            waiting: false,
        };
    },
    methods: {
        close() {
            console.log(this.current_user);
            this.$emit("attendChangeClose", 6, ["attend창 닫기"]);
        },
        change() {
            this.ifLoading = 0;
            this.waiting = true;
            console.log(this.attend.desc_value);
            console.log(this.attend.run);
            console.log(this.backupAttend.run);
            console.log(this.attend.attend);
            let errMsg = [];
            if (
                !this.attend.desc_value ||
                this.attend.desc_value == "" ||
                !this.attend.attend ||
                this.attend.attend == "" ||
                !(
                    this.attend.run == 0 ||
                    this.attend.run == "0" ||
                    Number(this.attend.run) == Number(this.backupAttend.run)
                )
            ) {
                if (!this.attend.desc_value || this.attend.desc_value == "") {
                    errMsg.push("상태를 입력하지 않았습니다.");
                }
                if (
                    (!this.attend.run || this.attend.run == "") &&
                    Number(this.attend.run) != 0
                ) {
                    errMsg.push("바퀴수를 입력하지 않았습니다.");
                }
                if (
                    !(
                        this.attend.run == 0 ||
                        this.attend.run == "0" ||
                        Number(this.attend.run) == Number(this.backupAttend.run)
                    )
                ) {
                    errMsg.push("바퀴수는 현재와 같거나 0이어야 합니다.");
                }
                this.waiting = false;
                this.ifLoading = 1;
                console.log("err check", errMsg);
                this.$emit("attendChangeClose", 5, errMsg);
                return;
            }

            errMsg.push("변경하였습니다.");
            axios
                .patch("/api/attends/" + this.user.id, this.attend)
                .then((res) => {
                    console.log(res);
                    this.$emit("attendChangeClose", 4, errMsg);
                })
                .catch((err) => {
                    console.log(err);
                });
            this.ifLoading = 1;
            this.waiting = false;
        },
    },
};
</script>

<style>
input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}
</style>

<style>
.loading {
    position: absolute;
    height: auto;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
}
</style>
