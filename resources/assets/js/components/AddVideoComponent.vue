<template>
    <div>
        <check-url @receiveResponse="receiveResponse($event)"></check-url>
        <found-video-from-url :url-data="responseData.urlData"></found-video-from-url>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                responseData: {
                    urlData:   {},
                    errorData: {}
                }
            }
        },
        methods: {
            receiveResponse: function (responseData) {
                this.responseData = responseData;
            },
        },
    }
</script>

<style scoped>

</style>