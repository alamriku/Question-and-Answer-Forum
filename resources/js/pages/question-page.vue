<template>
    <div class="container">
        <question :question="question"></question>
        <answers :question="question"></answers>
    </div>
</template>

<script>
    import Question from "../components/Question";
    import Answers from "../components/Answers";

    export default {
        props:['question'],
        components:{Question,Answers}
    }
</script>
