<script setup>
import {computed, ref, watch} from "vue";
import {storeToRefs} from "pinia";
import debounce from 'lodash/debounce'
import {usePreOrderStore} from "../stores/preOrders.js";
import {useAuthStore} from "../stores/auth.js";

const store = usePreOrderStore()
const authStore = useAuthStore()
const {preOrders, pagination, isLoading} = storeToRefs(store)
const itemsPerPage = ref(10)
const search = ref('')
const searchTerm = ref('')

const headers = [
    {title: 'Id', key: 'id'},
    {title: 'User Name', key: 'user.name', sortable: false},
    {title: 'User Email', key: 'user.email', sortable: false},
    {title: 'Total', key: 'total'},
    {title: 'Status', key: 'status'},
    {title: 'Action', key: 'action', sortable: false},
]

const itemsPerPageOptions = [
    {value: 10, title: '10'},
    {value: 25, title: '25'},
    {value: 50, title: '50'},
    {value: 100, title: '100'},
]

const debouncedSearch = debounce((val) => search.value = val, 1000);

watch(searchTerm, (newValue) => {
    debouncedSearch(newValue);  // Trigger the debounced search whenever searchTerm changes
});

// Hide delete icon for manager
const computedHeaders = computed(() => {
    if (authStore?.user?.role === 'admin') {
        return headers;
    }
    return headers.filter(header => header.key !== 'action');
});
</script>

<template>
    <!-- Page Heading -->
    <v-card class="mb-4">
        <v-toolbar color="deep-purple accent-4" dark justify="between">
            <v-toolbar-title>Pre Order</v-toolbar-title>
            <v-breadcrumbs :items="['Dashboard', 'Pre Order']"></v-breadcrumbs>
        </v-toolbar>

        <v-data-table-server
            v-model:items-per-page="itemsPerPage"
            :headers="computedHeaders"
            :items="preOrders"
            :items-length="pagination.total"
            item-value="name"
            @update:options="store.getPreOrders"
            @update:sortBy="store.updateShortBY"
            :items-per-page-options="itemsPerPageOptions"
            :loading="isLoading"
            :search="search"
        >
            <template v-slot:item.action="{ item }">
                <v-icon
                    icon="mdi-delete"
                    class="cursor-pointer"
                    color="red-accent-3"
                    @click="store.deletePreOrder(item.id)"
                />
            </template>

            <template v-slot:tfoot>
                <tr>
                    <td colspan="2">
                        <v-text-field
                            v-model="searchTerm"
                            class="ma-2"
                            density="compact"
                            placeholder="Search..."
                            hide-details clearable
                        />
                    </td>
                </tr>
            </template>
        </v-data-table-server>
    </v-card>
</template>

<style scoped>

</style>
