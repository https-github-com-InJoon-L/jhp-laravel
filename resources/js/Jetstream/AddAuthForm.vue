<template>
    <div class="py-3">
    <form action="/setInfo/save" method="post">

        <div class="flex flex-col mb-4">
            <label class="mb-2 font-bold text-lg text-gray-900" for="phone_number">전화번호</label>
            <input  placeholder="010-0000-0000" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" name="phone_number" id="phone_number">
            <!-- <has-error :form></has-error> -->
        </div>
        <div class="flex flex-col mb-4">
            <label class="mb-2 font-bold text-lg text-gray-900" for="last_name">반</label>
            <label><input type="radio" name="class" value="WDJ"> WDJ</label>
            <label><input type="radio" name="class" value="CPJ"> CPJ</label>
        </div>
        <div class="flex flex-col mb-4">
            <label class="mb-2 font-bold text-lg text-gray-900" for="sid">학번</label>
            <input  placeholder="18-000000" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="number" name="sid" id="sid">
        </div>
        <div class="flex flex-col mb-4">
            <label class="mb-2 font-bold text-lg text-gray-900" for="password">직업</label>
            <label><input type="radio" name="position" value="student"> 학생</label>
        </div>
        <input type="submit" class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded" value="제출">
        <input type="hidden" name="_token" :value="csrf">
    </form>
</div>
</template>

<script>
    import Input from './Input.vue'

    export default {
        data: function () {
            return {

                msg: '',
                csrf: document.head.querySelector('meta[name="csrf-token"]').content,
            }
        },
        components: {

            Input
        },
    }
</script>
