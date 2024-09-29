<script setup>
import {useAuthStore} from "../../stores/auth.js";
import {storeToRefs} from "pinia";

const store = useAuthStore()
const { token, user } = storeToRefs(store)
</script>

<template>
    <v-navigation-drawer>
        <v-list>
            <v-list-item
                prepend-avatar="https://randomuser.me/api/portraits/women/85.jpg"
                :subtitle="user?.email"
                :title="user?.name"
            ></v-list-item>
            <v-divider></v-divider>
            <v-list-item link to="/dashboard" title="Dashboard" prepend-icon="mdi-view-dashboard"></v-list-item>
            <v-list-item link to="/pre-orders" title="Pre Order" prepend-icon="mdi-cart-arrow-down"></v-list-item>
            <v-list-item link title="Logout" prepend-icon="mdi-logout" @click="store.logout()"></v-list-item>
        </v-list>
    </v-navigation-drawer>
</template>

<style scoped>

</style>
