<answer :answer="{{$answer}}" inline-template>
    <div class="media post">
{{--        @include('shared._vote',['model'=>$answer])--}}
        <vote :model="{{$answer}}" name="answer"></vote>
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
                            @can('update',$answer)
                                <a @click.prevent="edit" class="btn btn-sm btn-outline-info">Edit</a>
                            @endcan
                            @can('delete',$answer)
                                    <button class="btn btn-sm btn-outline-danger" @click="destroy" >Delete</button>
                                @endcan
                        </div>

                    </div>
                    <div class="col-4"></div>
                    <div class="col-4 ">
                        @include('shared._author',['model'=>$answer,'label'=>'answered
                        '])

                    </div>
                </div>
            </div>
        </div>
    </div>

</answer>
