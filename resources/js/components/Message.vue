<template>
    <div
        class="message"
        :class="isOwnMessage ? 'message-own' : ''"
    >
        <span>{{ message.body }}</span><span> - <i>{{ getSignature }}</i></span>
        <div class="row">
            <div class="col-6"><small>{{ message.timeAgo }}</small></div>
            <div v-if="isOwnMessage" class="col-6 text-right"><i>{{ message.status }}</i></div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        user: {
            type: Object,
            default: null,
        },
        message: {
            type: Object,
            default: null,
        },
    },
    computed: {
        isOwnMessage() {
            return this.user.id === this.message.userId;
        },
        getSignature() {
            return this.isOwnMessage ? 'you' : this.message.username;
        },
    },
}
</script>

<style lang="scss" scoped>
.message {
    background: lightgrey;
    padding: 10px;
    max-width: 85%;
    margin-top: .25rem;
    border-radius: 0 20px 20px 20px;
}
.message-own {
    float: right;
    width: 100%;
    background: #2b2d3c;
    border-radius: 20px 0 20px 20px;
    color: white;
}
</style>
