<template>
    <tr class="flex">
        <td class="w-1/3 px-6 py-4 whitespace-nowrap text-center">
            <div class="max-w-max min-w-max text-center inline">
                <span class="text-sm text-center text-gray-900">
                    {{attend.attend}}
                </span>
            </div>
        </td>
        <td class="w-1/3 px-6 py-4 whitespace-nowrap text-center">
            <div class="max-w-max min-w-max text-center inline">
                <span class="text-sm text-center text-gray-900">
                    {{attend.run}}
                </span>
            </div>
        </td>
        <td class="w-1/3 px-6 py-4 whitespace-nowrap text-center">
            <div class="max-w-max min-w-max text-center inline">
                <span class="text-sm text-center text-gray-900">
                    {{attend.desc_value}}
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
            attend:Object,
        },
        data(){
            return{
            }
        },
        methods:{
        }
    }
</script>
