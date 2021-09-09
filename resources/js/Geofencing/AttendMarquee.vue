<template>
  <div class=" flex-col  md:flex-row justify-center gap-3  ">
        <div class="min-w-full p-4">
            <div
                class=" bg-white max-w-full shadow-lg   mx-auto border-b-4 border-info rounded-2xl overflow-hidden  hover:shadow-2xl transition duration-500 transform hover: cursor-pointer">
                <div class="bg-info  flex h-20  items-center">
                    <h1 class="text-white ml-4 border-2 py-2 px-4 rounded-full text-sm font-bold">{{ date }} 출석현황</h1>
                </div>
                <div class="p-3 text-lg">
                  <VTextMarquee :speed="40" :content="text" class="text-primary"></VTextMarquee>
                </div>
            </div>
        </div>


    </div>
</template>

<script>
    import { VTextMarquee } from 'vue-text-marquee';
    export default {
        data: function () {
            return {
                name: 'HelloWorld',
                date: 'hihiihi',
                text: '',
                latersText: '',
                absencersText: '',
                laters: [],
                absencers: [],
            }
        },
        components: {
            VTextMarquee: VTextMarquee
        },
        mounted() {
            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
            var yyyy = today.getFullYear();

            today = yyyy + '-' + mm + '-' + dd;
            this.date = today;
            axios.get('/api/class/2?date=' + this.date, null)
                .then(response => {
                    this.attends = response.data.data;
                    this.isLoading = 1;

                    this.attends.map(element => {
                        if(element.desc_value == "출석") {
                        } else if(element.desc_value == "지각") {
                            this.laters.push(element.name)
                        } else {
                            this.absencers.push(element.name)
                        }   
                    })
                    if(this.laters[0]) {
                        this.latersText = "[" + this.laters + "]"
                    } else {
                        this.latersText = "없음"
                    }
                    if(this.absencers[0]) {
                        this.absencersText = "[" + this.absencers + "]"
                    } else {
                        this.absencersText = "없음"
                    }
                    if(this.attends[0]) {
                        this.text = "오늘 (자습지각) : " + this.latersText +",   (자습결석) :" +this.absencersText;
                    } else {
                        this.text = "오늘 [자습]출석 정보가 없습니다"
                    }
                    
                })
          
        },
        methods: {
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