<template>
    <div class="message-input">
        <textarea
            v-model="message.input"
            class="form-control margin-top-md"
            placeholder="Send a message..."
            rows="3"
            @keydown="isTyping"
            @keyup.enter="submitMessage"
        >
        </textarea>
        <span
            v-show="typing"
            class="info-block"
        >
            ... {{ respondent }} is typing
        </span>
        <button
            @click="submitMessage"
            class="btn btn-dark float-right btn-submit margin-top-sm"
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
    data() {
        return {
            message: {
                input: '',
            },
            respondent: null,
            typing: false,
            isTimeoutRunning: false,
        };
    },
    created() {
        this.registerEchoTypingListener();
        this.registerEventBusTypingListener();
    },
    methods: {
        isTyping(e) {
            if (e.code !== 'Enter') {
                this.emitEchoTypingEvent();
            }
        },
        submitMessage() {
            // todo some validation

            const messageBody = this.message.input;
            const tempMessageId = this.randomString();
            this.message.input = '';

            this.passMessageToParent(messageBody, tempMessageId);
            this.passMessageToStorage(messageBody)
                .then(response => {
                    this.updateMessageStatus('sent', tempMessageId, response.data.message);
                    this.emitEchoNewMessageEvent();
                })
                .catch(() => {
                    this.updateMessageStatus('failed to send', tempMessageId, messageBody);
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
        updateMessageStatus(status, tempMessageId, message) {
            EventBus.$emit('message-status-update', {
                status: status,
                tempMessageId: tempMessageId,
                message: message
            });
        },
        registerEchoTypingListener() {
                Echo.private('chat')
                    .listenForWhisper('typing', (e) => {
                        this.respondent = e.respondent;
                        this.typing = e.typing;

                        if (! this.isTimeoutRunning) {
                            this.isTimeoutRunning = true;

                            setTimeout(() => {
                                this.hideTypingIndicator();
                                this.isTimeoutRunning = false;
                            }, 900);
                        }

                    });
        },
        registerEventBusTypingListener() {
            EventBus.$on('hide-typing-indicator', () => this.hideTypingIndicator())
        },
        emitEchoTypingEvent() {
            let channel = Echo.private('chat');

            setTimeout(() => {
                channel.whisper('typing', {
                    respondent: this.user.name,
                    typing: true
                });
            }, 300);
        },
        emitEchoNewMessageEvent() {
            Echo.private('chat').whisper('new-message', {});
        },
        hideTypingIndicator() {
            this.typing = false;
        },
        randomstring() {
            // Generate a random string in JS
            // https://gist.github.com/6174/6062387
            return Math.random().toString(36).substring(2, 15) +
                Math.random().toString(36).substring(2, 15);
        }
    }
}
</script>

<style lang="scss" scoped>
.info-block {
    font-style: italic;
    color: darkgrey;
    position: relative;
    left: 0.25rem;
}
</style>
