<template>
    <div>
        <div v-show="isActive" class="container w-full mx-auto text-center">
            <p class="py-2">See a Jim Stoppani video that we missed?</p>
            <a :href="addVideoRoute"
               class="btn btn-orange">
                Add a Jim Stoppani Video
            </a>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['addVideoRoute', 'user'],

        computed: {
            isActive() {
                return !this.user ? false : this.user.status;
            }
        },
    }
</script>
