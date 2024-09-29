<script setup>
import { useAuthStore } from '../stores/auth'
import { storeToRefs } from 'pinia'
const store = useAuthStore()
const { token, user } = storeToRefs(store)
</script>

<template>
</template>

<style scoped>

</style>
