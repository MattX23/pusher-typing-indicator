<template>
    <div class="message-input">
        <textarea
            v-model="message.input"
            class="form-control margin-top-md"
            placeholder="Send a message..."
            rows="3"
        >
        </textarea>
        <span
            v-show="isTyping"
            class="info-block"
        >
            @{{ respondent }} is typing...
        </span>
        <button
            @click="submitMessage"
            class="btn btn-primary float-right btn-submit margin-top-sm"
        >
            Send
        </button>
    </div>
</template>

<script>
export default {
    props: {
        user: {
            type: Object,
            default: null,
        },
    },
    // todo add messages to array of messages once created
    data() {
        return {
            message: {
                input: '',
            },
            isTyping: false,
            respondent: null,
            messages: [],
        };
    },
    methods: {
        submitMessage() {
            // todo some validation

            axios
                .post(`/api/message/send`, {
                    body: this.message.input,
                    user_id: this.user.id,
                })
                .then(response => {
                    console.log(response.data);
                })
                .catch(errors => {
                    console.log(errors);
                    alert("whoops");
                })
        },
    }
}
</script>

<style lang="scss" scoped>
.message-input {
    position: absolute;
    bottom: 1rem;
    width: 96%;
    margin: 15px;
    left: 0;
}
.info-block {
    font-style: italic;
    color: darkgrey;
    position: relative;
    left: 0.5rem;
}
</style>
