<template>
    <div>
        <tags-input element-id="tags"
                    v-model="formData.selectedTags"
                    :existing-tags="{
        'web-development': 'Web Development',
        'php': 'PHP',
        'javascript': 'JavaScript',
    }"
                    :typeahead="true"
        ></tags-input>

        <div>
            <button class="btn btn-orange" :disabled="saveDisabled" v-on:click="save()">Save</button>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            videoId: {
                type:    Number,
                default: 0
            },
        },
        data() {
            return {
                formData: {
                    selectedTags: []
                },
                saving:       false
            }
        },
        computed: {
            saveDisabled() {
                return !this.formData.selectedTags.length && !this.saving;
            }
        },
        methods:  {
            save() {
                this.saving = true;
                axios.patch('/api/approveVideos/' + this.videoId, this.formData)
                    .then(() => {
                        this.saving = false;
                    })
                    .catch((error) => {
                        this.saving = false;
                        console.log(error.response);
                    });
            }
        },
    }
</script>

<style scoped>

</style>