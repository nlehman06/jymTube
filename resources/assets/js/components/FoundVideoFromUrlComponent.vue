<template>
    <div v-if="showFoundData">
        <div class="mb-2 border-solid border-grey-light rounded border shadow-sm">
            <div class="text-orange bg-grey-lighter px-2 py-3 border-solid border-grey-light border-b font-title uppercase">
                We found a video from {{ urlData.provider }}!
            </div>
            <div class="p-3">
                <div class="card">
                    <div class="card-image" :style="`background-image: url(${urlData.picture});`"
                         :title="urlData.title"></div>
                    <div class="card-body">
                        <div class="mb-8">
                            <div class="card-title">{{ urlData.title }}</div>
                            <p class="card-description">{{ urlData.description }}</p>
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
                        <div class="mx-auto mt-8 flex items-center flex-col">
                            <button class="btn btn-orange" id="submitVideoForReviewButton" type="button"
                                    :disabled="loading" @click="submitVideoForReview" v-show="!showThankYou">
                                {{ submitButtonText }}
                            </button>
                            <p v-show="showThankYou">Thank you for your help in adding mass to Jym Tube!</p>

                            <a href="/home" class="btn btn-orange" id="continueToHome" v-show="showThankYou">
                                Continue to GSD!
                            </a>
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
        data() {
            return {
                loading:          false,
                submitButtonText: 'Send Video for Review',
                showThankYou:     false
            }
        },
        computed: {
            showFoundData:  function () {
                return Object.keys(this.urlData).length !== 0
            },
            videoCreatedOn: function () {
                return moment(this.urlData.created_on).format('MMMM Do YYYY, h:mm a');
            }
        },
        methods:  {
            submitVideoForReview() {
                this.loading = true;
                this.submitButtonText = 'Please Wait...';

                axios.post('/api/addVideo', this.urlData)
                    .then(() => {
                        this.loading = false;
                        this.showThankYou = true;
                    })
            }
        },
    }
</script>
