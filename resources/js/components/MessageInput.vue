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
import { EventBus } from "../eventbus/event-bus";

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
        };
    },
    methods: {
        submitMessage() {
            // todo some validation

            const messageBody = this.message.input;
            const tempMessageId = Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15);
            this.message.input = '';

            this.passMessageToParent(messageBody, tempMessageId);
            this.passMessageToStorage(messageBody)
                .then(response => {
                    EventBus.$emit('message-status-update', {
                        status: 'sent',
                        tempMessageId: tempMessageId,
                        message: response.data.message
                    })
                })
                .catch(() => {
                    EventBus.$emit('message-status-update', {
                        status: 'failed',
                        tempMessageId: tempMessageId,
                        message: messageBody
                    })
                });
        },
        passMessageToParent(messageBody, tempMessageId) {
            const message = {
                body: messageBody,
                username: 'you',
                userId: this.user.id,
                timeAgo: 'just now',
                status: 'sending',
                id: tempMessageId,
            };

            EventBus.$emit('message-update', message);
        },
        passMessageToStorage(messageBody) {
            return axios
                .post(`/api/message/send`, {
                    body: messageBody,
                    user_id: this.user.id,
                })
                .then(response => {
                    return response.data;
                });
        },
    }
}
</script>

<style lang="scss" scoped>
.info-block {
    font-style: italic;
    color: darkgrey;
    position: relative;
    left: 0.5rem;
}
</style>
