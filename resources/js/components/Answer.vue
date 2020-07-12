<template>
    <div>
        <div class="media post">

            <vote :model="answer" name="answer"></vote>
            <div class="media-body">

                <form v-if="editing" @submit.prevent>
                    <div class="form-group">
                        <textarea name="" v-model="body" rows="10" class="form-control" required></textarea>
                    </div>
                    <button  class="btn btn-outline-info" @click="update" :disabled="isInvalid">Update</button>
                    <button class="btn btn-outline-secondary" @click="cancel">Cancel</button>
                </form>
                <div v-else="!editing">
                    <div v-html="bodyHtml">
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="ml-auto">

                                <a v-if="this.$authorize('modify',this.answer)" @click.prevent="edit" class="btn btn-sm btn-outline-info">Edit</a>


                                <button v-if="this.$authorize('modify',this.answer)" class="btn btn-sm btn-outline-danger" @click="destroy" >Delete</button>

                            </div>

                        </div>
                        <div class="col-4"></div>
                        <div class="col-4 ">
                            <user-info :model="answer" label="Answered"></user-info>

                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
</template>

<script>
    import UserInfo from "../components/UserInfo";
    import Vote from "../components/Vote";
    export default {
        props:['answer'],
        data(){
            return {
                editing:false,
                body:this.answer.body,
                bodyHtml:this.answer.body_html,
                id:this.answer.id,
                questionId:this.answer.question_id,
                beforeEditCache:null

            }
        },
        methods:{
            test(){
                console.log(this.$authorize('modify',this.answer));
            },
            edit(){
                this.beforeEditCache=this.body;
                this.editing=true;
            },
            cancel(){
              this.body = this.beforeEditCache;
              this.editing=false;
            },
            update(){
                axios.patch(this.endpoint,{
                    body:this.body
                }).then(res=>{
                        console.log(res);
                        this.editing = false;
                        this.bodyHtml = res.data.body_html;
                        this.$toast.success(res.data.message,'Success',{ timeout:3000 });

                    })
                    .catch(error=>{
                        console.log('something went wrong');
                        console.log(error.response);
                        this.$toast.success(error.data.message,'Error',{ timeout:3000 });
                    });
            },
            destroy(){
                this.$toast.question('Are you sure about that?','Warning',{
                    timeout: 20000,
                    close: false,
                    overlay: true,
                    displayMode: 'once',
                    id: 'question',
                    zindex: 999,
                    title: 'Hey',

                    position: 'center',
                    buttons: [
                        ['<button><b>YES</b></button>',  (instance, toast) => {

                            axios.delete(this.endpoint)
                                .then(res=>{
                                    this.$emit('deleted')
                                });
                            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                        }, true],
                        ['<button>NO</button>', function (instance, toast) {

                            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                        }],
                    ],

                });


            }
        },
        computed:{

            isInvalid(){
                return  this.body.length <10;
            },
            endpoint(){
                return `/questions/${this.questionId}/answers/${this.id}`;
            }
        },
        components:{
            UserInfo,Vote
        }
    }
</script>
