<template>
    <div>
        <nav class="bg-grey-lightest p-3 shadow">
            <div class="flex items-center justify-between flex-wrap sm:flex-no-wrap">
                <div class="flex items-center text-white mr-6 font-title mr-6 w-1/4 text-3xl">
                    <a href="/" class="text-orange-dark no-underline">JymTube</a>
                </div>

                <div class="block sm:hidden">
                    <button @click="toggle"
                            class="flex items-center px-3 py-2 border rounded text-orange border-orange hover:text-orange-light hover:border-orange-light">
                        <svg class="fill-current h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <title>Menu</title>
                            <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"/>
                        </svg>
                    </button>
                </div>

                <div :class="open ? 'block': 'hidden'" class="w-full relative sm:block">

                    <div class="flex-grow sm:flex sm:items-center sm:w-auto">
                        <!-- Search Bar -->
                        <div class="text-white flex-grow px-6">
                            <div class="relative">
                                <input type="text" placeholder="IMPROVE YOURSELF"
                                       class="w-full rounded shadow appearance-none border font-title text-orange-darkest bg-orange-lightest text-xl pl-3 py-2 pr-10">
                                <button class="btn btn-orange absolute pin-t pin-r mt-px mr-px text-xl">
                                    Search
                                </button>
                            </div>
                        </div>

                        <!-- Avatar and name-->
                        <div v-if="auth"
                             class="text-orange-darker w-1/4 hover:text-orange cursor-pointer hidden sm:block"
                             @click="togglePullDownMenu">
                            <div class="flex justify-center items-center">
                                <img :src="user.avatar" class="rounded-full mr-3 w-10">
                                <span class="text-lg">{{ user.nickName ? user.nickName : user.email }}</span>
                                <svg class="fill-current w-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                                </svg>
                            </div>
                        </div>

                        <!-- Register or Login-->
                        <a :href="registerRoute" v-if="!auth"
                           class="px-4 font-title font-bold text-lg no-underline text-grey-darker ml-8 whitespace-no-wrap">
                            Sign Up
                        </a>
                        <a :href="loginRoute" v-if="!auth"
                           class="px-4 font-title font-bold text-lg text-orange no-underline whitespace-no-wrap">
                            Sign In
                        </a>
                    </div>
                    <div :class="dropDownOpen ? 'sm:flex' : 'sm:hidden'"
                         class="sm:absolute pin-r w-full sm:w-1/3 pt-6 flex-col bg-white text-orange-darkest shadow flex">
                        <div class="w-full p-6" v-if="canApproveVideos">
                            <a href="/approveVideos" class="link">Approve Videos</a>
                        </div>
                        <div class="w-full p-6" v-if="canManageCategories">
                            <a href="/categories" class="link">Manage Categories</a>
                        </div>
                        <div class="w-full p-6" v-if="isAdmin">
                            <a href="/users" class="link">Users</a>
                        </div>
                        <div class="w-full p-6">
                            <a @click="logout" class="cursor-pointer">Logout</a>
                        </div>
                    </div>

                </div>

            </div>
        </nav>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                open:         false,
                dropDownOpen: false
            }
        },
        props:   [
            'auth',
            'registerRoute',
            'loginRoute',
            'logoutRoute',
            'user',
            'isAdmin',
            'canApproveVideos',
            'canManageCategories'
        ],
        methods: {
            toggle() {
                this.open = !this.open;
            },
            togglePullDownMenu() {
                this.dropDownOpen = !this.dropDownOpen
            },
            logout() {
                axios.post(this.logoutRoute)
                    .then(() => {
                        window.location.href = this.loginRoute;
                    })
            }
        },

    }
</script>
