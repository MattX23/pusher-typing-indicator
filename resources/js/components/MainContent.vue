<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Heading
                    </div>
                    <div class="main-container">

                        <div class="card-body">
                            <div v-for="message in messages" :key="message.id">
                                <message
                                    :message="message"
                                    :user="user"
                                ></message>
                            </div>
                        </div>

                        <div class="card-body">
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
export default {
    props: {
        user: {
            type: Object,
            default: null,
        },
    },
    data() {
        return {
            messages: [],
        }
    },
    mounted() {
        this.fetchMessages();
    },
    methods: {
        fetchMessages() {
            axios
                .get(`/api/message/fetch-all`)
                .then(response => {
                    this.messages = response.data.data.messages;
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
</style>
