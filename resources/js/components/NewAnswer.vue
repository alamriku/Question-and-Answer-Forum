<template>
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h3>Your Answer</h3>
                    </div>
                    <hr>
                    <form @submit.prevent="create">

                        <div class="form-group">
                            <textarea required v-model="body" id="" rows="7"  class="form-control"></textarea>

                            <div class="invalid-feedback">

                            </div>

                        </div>
                        <div class="form-group">
                            <button class="btn btn-lg btn-outline-primary" :disabled="isInvalid">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</template>
<script>
    export default {
        props:['questionId'],

        data(){
            return {
                body:'',
            }
        },
        methods:{
          create(){
              axios.post(`/questions/${this.questionId}/answers`,{
                  body:this.body
              }).catch(error=>{
                  this.$toast.error(error.response.data.message,'Error');
              }).then(({data})=>{
                    this.$toast.success(data.message,'Success');
                    this.body='';
                    this.$emit('created',data.answer);
              })
          }
        },
        computed:{
            isInvalid(){
                return !this.$signedId || this.body.length < 10;
            }
        }
    }
</script>
