<template>
    <tr v-if="attend" class="flex">
        <td class="w-1/3 px-6 py-4 whitespace-nowrap text-center">
            <div class="max-w-max min-w-max text-center inline">
                <span class="text-sm text-center text-gray-900">
                    {{msg}}
                </span>
            </div>
        </td>
        <td class="w-1/3 px-6 py-4 whitespace-nowrap text-center">
            <div class="max-w-max min-w-max text-center inline">
                <span class="text-sm text-center text-gray-900">

                </span>
            </div>
        </td>
        <td class="w-1/3 px-6 py-4 whitespace-nowrap text-center">
            <div class="max-w-max min-w-max text-center inline">
                <span class="text-sm text-center text-gray-900">
                    {{attend}}
                </span>
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
            msg:String,
            attend:Number,
        },
        data(){
            return{
            }
        },
        methods:{
        }
    }
</script>
