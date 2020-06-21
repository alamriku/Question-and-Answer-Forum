<answer :answer="{{$answer}}" inline-template>
    <div class="media post">
        @include('shared._vote',['model'=>$answer])
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
                                <form class="form-delete" action="{{route('questions.answers.destroy',[$question->id,$answer->id])}} " method="post">
                                    {{method_field('DELETE')}}
                                    @csrf
                                    <button class="btn btn-sm btn-outline-danger" type="submit" onclick="return confirm('Are your Sure?')">Delete</button>
                                    @endcan
                                </form>
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
