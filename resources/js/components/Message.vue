<template>
    <div
        class="message"
        :class="isOwnMessage ? 'message-own' : 'message-other'"
    >
        <span>{{ message.body }}</span><span> - <i>{{ message.username }}</i></span>
        <div>{{ message.timeAgo }}</div>
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
    },
    data() {
        return {

        };
    },
    methods: {

    }
}
</script>

<style lang="scss" scoped>
.message {
    background: lightgrey;
    padding: 10px;
    border-radius: 3px;
    max-width: 85%;
}
.message-own {
    float: right;
    width: 100%;
    background: darkgrey;
}
</style>
