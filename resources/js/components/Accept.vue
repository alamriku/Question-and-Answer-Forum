<template>
    <div>

        <a v-if="authorize('accept',answer)" title="Mark this answer as best answer"
           :class="classes"
           @click.prevent="create"
        >
            <i class="fas fa-check fa-2x"></i>

        </a>




        <a v-if="accepted" title="The user Marked this answer as best answer"
           :class="classes"
        >
            <i class="fas fa-check fa-2x"></i>
        </a>


    </div>
</template>

<script>
    export default {
        props:['answer'],
        data(){
            return{
                isBest:this.answer.is_best,
                id:this.answer.id
            }
        },
        methods:{
            create(){
                axios.post(`/answers/${this.id}/accept`).then(
                    res=>{
                        this.$toast.success(res.data.message,'Success',{
                            timeout:3000,
                            position:'topRight'
                        });
                        this.isBest=true;
                    }).catch(err=>{
                        console.log(err);});

            }
        },
        computed:{
            canAccept(){
                return this.authorize('accept',this.answer)

            },
            accepted(){
                console.log(!this.canAccept && this.isBest);
                return !this.canAccept && this.isBest;

            },
            classes(){
                return ['mt-2',
                    this.isBest ? 'vote-accepted': ''
                ];
            }
        }

    }
</script>
