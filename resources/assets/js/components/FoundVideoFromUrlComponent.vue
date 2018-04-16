<template>
    <div v-if="showFoundData">
        <div class="mb-2 border-solid border-grey-light rounded border shadow-sm">
            <div class="text-orange bg-grey-lighter px-2 py-3 border-solid border-grey-light border-b font-title uppercase">
                We found a video from {{ urlData.provider }}!
            </div>
            <div class="p-3">
                <div class="w-full lg:flex">
                    <div class="h-48 lg:h-auto lg:w-48 flex-none rounded-t lg:rounded-t-none lg:rounded-l text-center overflow-hidden"
                         :title="urlData.title">
                        <img :src="urlData.picture">
                    </div>
                    <div class="border-r border-b border-l border-grey-light lg:border-l-0 lg:border-t lg:border-grey-light bg-white rounded-b lg:rounded-b-none lg:rounded-r p-4 flex flex-col justify-between leading-normal">
                        <div class="mb-8">
                            <div class="text-black font-bold text-xl mb-2">{{ urlData.title }}</div>
                            <p class="text-grey-darker text-base">{{ urlData.description }}</p>
                        </div>
                        <div class="flex items-center">
                            <img class="w-10 h-10 rounded-full mr-4"
                                 :src="urlData.from_profile"
                                 alt="Profile Picture">
                            <div class="text-sm">
                                <p class="text-black leading-none">{{ urlData.from_name }}</p>
                                <p class="text-grey-dark">
                                    {{ videoCreatedOn }}
                                </p>
                            </div>
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
            urlData: {},
        },
        computed: {
            showFoundData:  function () {
                return Object.keys(this.urlData).length !== 0
            },
            videoCreatedOn: function () {
                return moment(this.urlData.created_on).format('MMMM Do YYYY, h:mm a');
            }
        }
    }
</script>
