<template>
    <div v-if="showNotFound">

        <div class="mb-2 border-solid border-grey-light rounded border shadow-sm">
            <div class="text-orange bg-grey-lighter px-2 py-3 border-solid border-grey-light border-b font-title uppercase">
                {{ errorData.data.error_data.message }}
            </div>

            <div class="p-3">
                <div class="border-r border-b border-l border-grey-light lg:border-t lg:border-grey-light bg-white rounded-b lg:rounded-r p-4 leading-normal">
                    <div class="mb-8">
                        <div class="text-grey-darker text-base">
                            <p v-show="otherInfo !== ''">{{ otherInfo }}</p>
                            <p v-show="messageFromProvider !== ''">{{ messageFromProvider }}</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
    export default {
        props:    {
            errorData: {},
        },
        computed: {
            showNotFound:        function () {
                return Object.keys(this.errorData).length !== 0;
            },
            otherInfo:           function () {
                return this.errorData.data.error_data.other_info;
            },
            messageFromProvider: function () {
                return this.errorData.data.error_data.message_from_provider;
            }
        },
    }
</script>
