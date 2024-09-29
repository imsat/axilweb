<script setup>
import {onBeforeMount, reactive, ref} from "vue";
import {storeToRefs} from "pinia";
// import {useAuthStore} from "../stores/auth.js";
import {useProductStore} from "../stores/product.js";
import {usePreOrderStore} from "../stores/preOrders.js";

const store = usePreOrderStore()
const productStore = useProductStore()
// const useAuthStore = useAuthStore()
const {preOrderForm} = storeToRefs(store)
const {products} = storeToRefs(productStore)

console.log(products)


const valid = ref(false);

const form = reactive({
    name: '',
    email: '',
    phone: '',
    address: '',
    selectedProduct: null,
    quantity: 1,
});

onBeforeMount(() => productStore.getProducts())

// Validation rules
const required = (value) => !!value || 'Required.';
const email = (value) => /.+@.+\..+/.test(value) || 'E-mail must be valid.';

const submitOrder = () => {
    console.log('Pre-order Submitted:', form);
    alert('Your pre-order has been submitted!');
    resetForm();
};

// const resetForm = () => {
//     form.name = '';
//     form.email = '';
//     form.phone = '';
//     form.address = '';
//     form.selectedProduct = null;
//     form.quantity = 1;
// };

const formatCurrency = (value) => {
    return `$${parseFloat(value).toFixed(2)}`;
};

</script>

<template>
    <v-container>
        <v-row>
            <!-- Pre-order form -->
            <v-col cols="12" md="6">
                <v-card>
                    <v-card-title>Pre-order Form</v-card-title>
                    <v-card-text>
                        <v-form v-model="valid">
                            <!-- Product Selection -->
                            <v-select
                                v-model="form.selectedProduct"
                                :items="products"
                                label="Select Product"
                                item-title="name"
                                :rules="[required]"
                                required
                                clearable
                            >
                            </v-select>

                            <v-row justify="space-between">
                                <v-col cols="auto">
                                    <v-text-field
                                        v-model="form.quantity"
                                        label="Order Quantity"
                                        type="number"
                                        :rules="[required]"
                                        required
                                    ></v-text-field>
                                </v-col>

                                <v-col cols="auto">
                                    <v-btn
                                        elevation="4"
                                        size="large"
                                        prepend-icon="mdi-cart"
                                    >
                                        Add to Cart
                                    </v-btn>
                                </v-col>
                            </v-row>

                            <!--                            <v-row>-->
                            <!--                                <v-col cols="12">-->
                            <!--                                    <div class="d-flex align-center ">-->
                            <!--                                        &lt;!&ndash; Order Quantity &ndash;&gt;-->
                            <!--                                        <v-text-field-->
                            <!--                                            v-model="form.quantity"-->
                            <!--                                            label="Order Quantity"-->
                            <!--                                            type="number"-->
                            <!--                                            :rules="[required]"-->
                            <!--                                            required-->
                            <!--                                            class="mr-4"-->
                            <!--                                        ></v-text-field>-->

                            <!--                                        &lt;!&ndash; Add to Cart Button &ndash;&gt;-->
                            <!--                                        <v-btn-->
                            <!--                                            variant="outlined"-->
                            <!--                                            color="primary"-->
                            <!--                                            prepend-icon="mdi-cart"-->
                            <!--                                            size="x-large"-->
                            <!--                                        >-->
                            <!--                                        Add to Cart-->
                            <!--                                        </v-btn>-->
                            <!--                                    </div>-->
                            <!--                                </v-col>-->
                            <!--                            </v-row>-->

                            <!-- Customer Name -->
                            <v-text-field
                                v-model="form.name"
                                label="Full Name"
                                :rules="[required]"
                                required
                            ></v-text-field>

                            <!-- Customer Email -->
                            <v-text-field
                                v-model="form.email"
                                label="Email"
                                :rules="[required, email]"
                                required
                            ></v-text-field>

                            <!-- Customer Phone -->
                            <v-text-field
                                v-model="form.phone"
                                label="Phone Number"
                                :rules="[required]"
                                required
                            ></v-text-field>

                            <!-- Delivery Address -->
                            <v-textarea
                                v-model="form.address"
                                label="Delivery Address"
                                :rules="[required]"
                                required
                            ></v-textarea>

                        </v-form>
                    </v-card-text>

                    <v-card-actions>
                        <v-btn :disabled="!valid" @click="submitOrder" color="primary">Submit Pre-order</v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>

            <!-- Product List -->
            <v-col cols="12" md="6">
                <v-card>
                    <v-card-title>Cart</v-card-title>
                    <v-card-text>
                        <v-list>
                            <v-list-item v-for="product in products" :key="product.name">
                                <!--                                <v-list-item-content>-->
                                <!--                                    <v-list-item-title>{{ product.name }}</v-list-item-title>-->
                                <!--                                    <v-list-item-subtitle>{{ formatCurrency(product.price) }}</v-list-item-subtitle>-->
                                <!--                                </v-list-item-content>-->
                            </v-list-item>
                        </v-list>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<style scoped>

</style>
