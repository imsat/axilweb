<script setup>
import Sidebar from "./components/layouts/Sidebar.vue";
import {useAuthStore} from "./stores/auth.js";
const store = useAuthStore()
</script>
<template>
    <v-app>
        <v-app-bar :elevation="2" app color="primary" dark>
<!--            <template v-slot:prepend>-->
<!--                <v-app-bar-nav-icon></v-app-bar-nav-icon>-->
<!--            </template>-->

            <v-app-bar-title>
                <router-link to="/" class="text-decoration-none text-white">AxilWeb</router-link>
            </v-app-bar-title>

            <v-spacer></v-spacer>

            <v-btn
                v-if="!store.token"
                to="/login"
                link
                prepend-icon="mdi-security"
                text="Admin Login"
                slim
            ></v-btn>
        </v-app-bar>

        <Sidebar v-if="store.token" />

        <v-main>
            <v-container fluid>
                <router-view/>
            </v-container>
        </v-main>
    </v-app>
</template>

<style scoped>
</style>
