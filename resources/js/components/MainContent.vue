<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Heading
                    </div>
                    <div class="main-container">

                        <div class="card-body messages">
                            <div v-for="message in messages" :key="message.id">
                                <div :class="message.userId === user.id ? 'message-container' : ''">
                                    <message
                                        :message="message"
                                        :user="user"
                                    ></message>
                                </div>
                            </div>
                        </div>

                        <div class="card-body message-input-container">
                            <message-input
                                :user="user"
                            ></message-input>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
    created() {
        EventBus.$on('message-update', message => {
            this.messages.unshift(message);
        });

        EventBus.$on('message-status-update', (data) => {
            this.updateMessageStatus(data);
        });
    },
    mounted() {
        this.fetchMessages();
    },
    data() {
        return {
            messages: [],
        }
    },
    methods: {
        fetchMessages() {
            axios
                .get(`/api/message/fetch-all`)
                .then(response => {
                    this.messages = response.data.data.messages.reverse();
                });
        },
        updateMessageStatus(data) {
            this.messages.forEach(function(tempMessage) {
                if (tempMessage.id === data.tempMessageId) {
                    tempMessage.status = data.status;
                    tempMessage.id = data.message.id;
                    tempMessage.timeAgo = data.message.timeAgo;
                }
            });
        },
    },
}
</script>

<style lang="scss" scoped>
.btn-submit {
    min-width: 125px;
}
.main-container {
    height: 85vh;
}
.message-container {
    display: flex;
    flex-direction: column;
    flex-wrap: wrap;
    align-content: flex-end;
}
.message-input-container {
    position: absolute;
    bottom: 0;
    width: 96%;
    margin: 15px;
    left: 0;
    background: white;
}
.messages {
    overflow: scroll;
    height: 65vh;
    display: flex;
    flex-direction: column-reverse;
}
</style>
