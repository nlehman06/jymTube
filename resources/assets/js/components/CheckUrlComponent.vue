<template>
    <div>
        <form role="form">
            <div class="form-group items-center">
                <label for="url" class="label">Enter the URL of the video</label>
                <input type="text" id="url" name="url" v-model="urlToCheck"
                       class="input-text w-full md:w-1/2 sm:w-full">
            </div>

            <div class="form-group items-center">
                <button class="btn btn-orange" id="checkUrlButton" type="button" :disabled="loading" @click="check">
                    {{ checkUrlButtonText }}
                </button>
            </div>

        </form>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                urlToCheck:         '',
                responseData:       {
                    urlData:   {},
                    errorData: {}
                },
                checkUrlButtonText: 'Check URL',
                loading:            false
            }
        },
        methods: {
            check() {
                const t = this;
                t.checkUrlButtonText = 'Checking...';
                t.loading = true;
                t.responseData = {
                    urlData:   null,
                    errorData: null
                };

                axios.post('/api/addVideo/checkURL', {url: t.urlToCheck})
                    .then(({data}) => {
                        t.checkUrlButtonText = 'Check URL';
                        t.loading = false;
                        if (data.success) {
                            t.responseData.urlData = data.url_data;
                            t.$emit('receiveResponse', t.responseData);
                        }
                    })
                    .catch((error) => {
                        t.checkUrlButtonText = 'Check URL';
                        t.loading = false;
                        t.responseData.errorData = error.response;
                        t.$emit('receiveResponse', t.responseData);
                    })
            }
        },
    }
</script>