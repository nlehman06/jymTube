<template>
    <div>
        <check-url @receiveResponse="receiveResponse($event)"></check-url>
        <found-video-from-url :url-data="responseData.urlData"></found-video-from-url>
        <url-not-found-component :error-data="responseData.errorData"></url-not-found-component>
    </div>
</template>

<script>
    import CheckUrl from './CheckUrlComponent.vue';
    import FoundVideoFromUrl from './FoundVideoFromUrlComponent.vue';
    import UrlNotFoundComponent from "./UrlNotFoundComponent.vue";

    export default {
        components: {
            CheckUrl,
            FoundVideoFromUrl,
            UrlNotFoundComponent
        },
        data() {
            return {
                responseData: {
                    urlData:   {},
                    errorData: {}
                }
            }
        },
        methods:    {
            receiveResponse: function (responseData) {
                this.responseData = responseData;
            },
        },
    }
</script>

<style scoped>

</style>