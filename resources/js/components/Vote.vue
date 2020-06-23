<template>
    <div class="d-flex flex-column vote-controls">
        <a @click.prevent="voteUp" :title="title('up')"
           class="vote-up" :class="classes"

        >

            <i class="fas fa-caret-up fa-3x"></i>
        </a>
        <span class="votes-count">{{count}}</span>
        <a @click.prevent="voteDown" :title="title('down')"
           class="vote-down" :class="classes"

        >

            <i class="fas fa-caret-down fa-3x"></i>

        </a>


        <favorite v-if="name === 'question'" :question="model"></favorite>

        <accept v-else="name === 'answer'" :answer="model"></accept>


    </div>
</template>
<script>
    import favorite from './Favorite.vue'
    import accept from './Accept.vue'
    export default {
        data(){
          return{
              count:this.model.votes_count,
              id:this.model.id
          }

        },
        props:['name','model'],
        computed:{
            classes(){
                return this.signedId ? '' : 'off';
            },
            endpoint(){
                return `/${this.name}s/${this.id}/vote`
            }
        },
        methods:{
            title(voteType){
                let titles = {
                    up:`This ${this.name} is useful`,
                    down:`This ${this.name} is not useful`
                };
                return titles[voteType];
            },
            voteUp(){
                this._vote(1);

            },
            voteDown(){

                this._vote(-1)
            },
            _vote(vote){
                if(!this.$signedId){
                    this.$toast.warning(`Please login to vote this ${this.name}`,"Warning",{
                        timeout:3000,
                        position:'topRight'
                    });
                    return;
                }
                axios.post(this.endpoint,{vote})
                    .then(res=>{
                        this.$toast.success(res.data.message,"Success",{
                            timeout:3000,
                            position:'topRight'
                        });
                        this.count = res.data.votesCount;
                    });
            }
        },
        components:{
            favorite,
            accept
        }
    }
</script>
