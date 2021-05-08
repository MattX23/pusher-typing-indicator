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
                            <message-input></message-input>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    mounted() {

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
