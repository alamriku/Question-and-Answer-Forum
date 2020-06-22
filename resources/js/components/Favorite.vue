<template>
    <a href="" title="Click to mark as favourite question(click again to undo)"
       :class="classes" @click.prevent="toggle"
    >
        <i class="fas fa-star fa-2x"></i>


        <span class="favorites-count">{{count}}</span>
    </a>
</template>
<script>
    export default {
        props:['question'],
        data(){
            return{
                isFavorited:this.question.is_favorited,
                count:this.question.favorites_count,

                id:this.question.id
            }
        },
        computed:{
            classes(){
                return[
                    'mt-2',
                    !this.signedIn ? 'off' : (this.isFavorited ? 'favorite' :'')
                ]
            },
            endpoint(){
                return `/questions/${this.id}/favorites`
            },
            signedIn(){
                console.log( window );
                return window.Auth.signedIn;
            },
        },
        methods:{
            toggle(){
                if(!this.signedIn){
                 this.$toast.warning("Please login to favorite this question","Warning",{
                    timeout:3000,
                     position:'bottomLeft'
                 });
                 return;
                }
                this.isFavorited ? this.destroy() :this.create();
            },
            destroy(){
                axios.delete(this.endpoint).then(
                    res=>{
                        this.count--;
                        this.isFavorited=false;
                    }
                );

            },
            create(){
                axios.post(this.endpoint).then(res=>{
                   this.count++;
                   this.isFavorited =true;
                });

            }
        }
    }
</script>
