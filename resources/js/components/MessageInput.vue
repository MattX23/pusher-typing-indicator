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
            @{{ user }} is typing...
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
    mounted() {

    },
    data() {
        return {
            message: {
                input: '',
            },
            isTyping: false,
            user: null,
        };
    },
    methods: {
        submitMessage() {
            // todo some validation

            axios
                .post(`/api/message/send`, {
                    message: this.message.input
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
