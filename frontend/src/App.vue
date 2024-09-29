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

            <v-app-bar-title>AxilWeb</v-app-bar-title>
        </v-app-bar>

        <Sidebar v-if="store.token" />

        <v-main>
            <v-container fluid>
                <router-view/>
            </v-container>
<!--                <v-row dense>-->
<!--                    <v-col-->
<!--                        v-for="n in 4"-->
<!--                        :key="n"-->
<!--                        cols="12"-->
<!--                    >-->
<!--                        <v-card-->
<!--                            :subtitle="`Subtitle for Content ${n}`"-->
<!--                            :title="`Content ${n}`"-->
<!--                            text="Lorem ipsum dolor sit amet consectetur, adipisicing elit.?"-->
<!--                        ></v-card>-->
<!--                    </v-col>-->
<!--                </v-row>-->
        </v-main>
    </v-app>
</template>

<style scoped>
.fill-height {
    height: 100vh;
}
</style>
