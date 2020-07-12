<template>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">

                <form v-if="editing" class="card-body" @submit.prevent="update">
                    <div class="card-title">
                        <input type="text" class="form-control form-control-lg"
                        v-model="title"
                        >

                    </div>
                    <hr>

                    <div class="media">

                        <div class="media-body">

                            <div class="form-group">
                                <textarea name="" v-model="body" rows="10" class="form-control" required></textarea>
                            </div>
                            <button  class="btn btn-outline-info" @click="update" :disabled="isInvalid">Update</button>
                            <button class="btn btn-outline-secondary" @click="cancel">Cancel</button>
                        </div>
                    </div>
                </form>

                <div v-else class="card-body">
                    <div class="card-title">
                        <div class="d-flex align-items-center">
                            <h2>{{title}}</h2>
                            <div class="ml-auto">
                                <a href="/questions" class="btn btn-outline-secondary">Back to question</a>
                            </div>
                        </div>

                    </div>
                    <hr>

                    <div class="media">

                        <vote :model="question" name="question"></vote>
                        <div class="media-body">
                            <div v-html="bodyHtml"></div>
                            <div class="row">
                                <div class="col-4">
                                    <div class="ml-auto">

                                        <a v-if="this.$authorize('modify',this.question)" @click.prevent="edit" class="btn btn-sm btn-outline-info">Edit</a>


                                        <button v-if="this.$authorize('deleteQuestion',this.question)" class="btn btn-sm btn-outline-danger" @click="destroy" >Delete</button>

                                    </div>
                                </div>
                                <div class="col-4"></div>
                                <div class="col-4">


                                    <user-info v-bind:model="question" label="Asked"></user-info>
                                </div>
                            </div>
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
        props:['question'],
        data(){
          return {
              title:this.question.title,
              body:this.question.body,
              bodyHtml:this.question.body_html,
              editing:false,
              id:this.question.id,
              beforeEditCache:{}
          }
        },
        components:{UserInfo,Vote},
        computed:{
            isInvalid(){
                return this.body.length <10 || this.title.length <10;
            },
            endpoint(){
                return `/questions/${this.id}`;
            }
        },
        methods:{
            edit(){
                this.beforeEditCache={
                    body:this.body,title:this.title
                };
                this.editing=true;
            },
            cancel(){
                this.body=this.beforeEditCache.body;
                this.title=this.beforeEditCache.title;
                this.editing=false;
            },
            update(){
                axios.put(this.endpoint,{
                    body:this.body,
                    title:this.title
                }).catch(({res})=>{
                    this.$toast.error(res.data.message,"Error",{timeout:3000})
                }).then(({data})=>{
                    this.bodyHtml=data.body_html;
                        this.$toast.success(data.message,"Success",{timeout:3000});
                        this.editing=false;
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
                                .then(({data})=>{
                                    this.$toast.success(data.message,'Success',{timeout:3000});
                                });
                            setTimeout(()=>{
                                window.location.href='/questions';
                            },3000);
                            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                        }, true],
                        ['<button>NO</button>', function (instance, toast) {

                            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                        }],
                    ],

                });


            }
        }
    }
</script>
