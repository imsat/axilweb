<script setup>
import {onBeforeUnmount} from "vue";
import {storeToRefs} from 'pinia'
import {useAuthStore} from '../stores/auth'

const store = useAuthStore()
const {loginForm} = storeToRefs(store)

onBeforeUnmount(() => {
    store.$reset()
})

// Form validation rules
const emailRules = [
    (v) => !!v || 'Email is required',
    (v) => /.+@.+\..+/.test(v) || 'E-mail must be valid',
];
const passwordRules = [(v) => !!v || 'Password is required'];

</script>

<template>
    <v-container class="fill-height d-flex align-center justify-center">
        <v-card class="pa-4" elevation="2" max-width="400" width="400">
            <v-card-title class="text-center">Login</v-card-title>
            <v-divider></v-divider>

            <v-form class="py-5" @submit.prevent="store.login">
                <v-text-field
                    v-model="loginForm.email"
                    label="Email"
                    type="email"
                    prepend-icon="mdi-email"
                    required
                    :rules="emailRules"
                    :error-messages="store.getError('email')"
                ></v-text-field>
                <v-text-field
                    v-model="loginForm.password"
                    label="Password"
                    type="password"
                    prepend-icon="mdi-lock"
                    :rules="passwordRules"
                    :error-messages="store.getError('password')"
                    required
                ></v-text-field>
                <v-btn
                    class="mt-5"
                    color="primary"
                    block
                    type="submit"
                    :loading="store.isLoading"
                >
                    Login
                </v-btn>
            </v-form>

            <v-row align="center">
                <v-col cols="auto">
                    <v-label>Select User to Login</v-label>
                    <v-radio-group row inline>
                        <v-radio label="Admin"
                                 value="admin"
                                 @click="store.setLoginForm({email: 'admin@mail.com', password: '123456'})"
                                 color="primary"
                        />
                        <v-radio label="Manager"
                                 value="manager"
                                 @click="store.setLoginForm({email: 'manager@mail.com', password: '123456'})"
                                 color="primary"
                        />
                    </v-radio-group>
                </v-col>
            </v-row>
        </v-card>
    </v-container>
</template>

<style scoped>
.fill-height {
    height: 100vh;
}
</style>
