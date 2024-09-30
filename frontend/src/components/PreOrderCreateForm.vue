<script setup>
import {computed, onBeforeMount, reactive, ref, watch} from "vue";
import {storeToRefs} from "pinia";
// import {useAuthStore} from "../stores/auth.js";
import {useProductStore} from "../stores/product.js";
import {usePreOrderStore} from "../stores/preOrders.js";

const store = usePreOrderStore()
const productStore = useProductStore()
// const useAuthStore = useAuthStore()
const {preOrderForm, cart, showPhoneField} = storeToRefs(store)
const {products} = storeToRefs(productStore)

const valid = ref(false);

onBeforeMount(() => productStore.getProducts())

// Validation rules
const email = (value) => {
    if (!value) return true; // No error if the field is empty
    return value.length > 0 && /.+@.+\..+/.test(value) || 'E-mail must be valid.'
};

const totalCartValue = computed(() => {
    let total = 0;
    // Check if preOrderForm and products are defined
    if (preOrderForm.value && Array.isArray(preOrderForm.value.products)) {
        for (let i = 0; i < preOrderForm.value.products.length; i++) {
            const product = preOrderForm.value.products[i];
            total += (product.quantity * product.price) || 0;
        }
    }

    return total;
});

</script>

<template>
    <v-container>
        <v-row>
            <!-- Pre-order form -->
            <v-col cols="12" md="7">
                <v-card>
                    <v-card-title>Create New Pre-order</v-card-title>
                    <v-card-text>
                        <v-form v-model="valid">
                            <v-select
                                v-model="cart.product"
                                :items="products"
                                label="Select Product"
                                item-title="name"
                                return-object
                                clearable
                                @update:modelValue="store.clearError('products')"
                                @click:clear="cart.quantity = 1; store.clearError('products')"
                                :error-messages="store.getError('products')"
                            >
                            </v-select>

                            <v-row justify="space-between">
                                <v-col cols="auto">
                                    <v-row>

                                        <v-col cols="auto">
                                            <v-text-field
                                                v-model="cart.quantity"
                                                label="Order Quantity"
                                                type="number"
                                                class="hide-arrows"
                                                readonly
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="2">
                                            <v-btn icon size="sm" color="green" class="mb-4"
                                                   :disabled="cart.product === null"
                                                   @click="cart.quantity += 1">
                                                <v-icon>mdi-plus</v-icon>
                                            </v-btn>
                                            <v-btn icon size="sm" color="red" @click="cart.quantity -= 1"
                                                   :disabled="cart.quantity === 1">
                                                <v-icon>mdi-minus</v-icon>
                                            </v-btn>
                                        </v-col>
                                    </v-row>
                                </v-col>

                                <v-col cols="auto">
                                    <v-btn
                                        :disabled="cart.quantity <= 0 || cart.product === null"
                                        elevation="4"
                                        size="large"
                                        prepend-icon="mdi-cart"
                                        color="indigo-darken-3"
                                        @click="store.addToCart(cart.product)"
                                    >
                                        Add to Cart
                                    </v-btn>
                                </v-col>
                            </v-row>


                            <v-text-field
                                v-model="preOrderForm.name"
                                label="Full Name"
                                :error-messages="store.getError('name')"
                                @input="store.clearError('name')"
                                required
                            ></v-text-field>

                            <v-text-field
                                v-model="preOrderForm.email"
                                label="Email"
                                :rules="[email]"
                                :error-messages="store.getError('email')"
                                @input="store.clearError('email')"
                                required
                            ></v-text-field>

                            <v-text-field
                                v-if="showPhoneField"
                                v-model="preOrderForm.phone"
                                type="number"
                                label="Phone Number"
                                :error-messages="store.getError('phone')"
                                @input="store.clearError('phone')"
                                required
                                class="hide-arrows"
                            ></v-text-field>

                            <v-textarea
                                v-model="preOrderForm.delivery_address"
                                label="Delivery Address"
                                :error-messages="store.getError('delivery_address')"
                                @input="store.clearError('delivery_address')"
                                required
                            ></v-textarea>

                            <div class="g-recaptcha" data-sitekey="6LcBr1MqAAAAAFQKtIUobH---MBcC76fIjL4aEpF"></div>

                        </v-form>
                    </v-card-text>

                    <template v-slot:actions>
<!--                        :disabled="!valid"-->
                        <v-btn
                            prepend-icon="mdi-plus"
                            color="primary"
                            text="Submit"
                            variant="elevated"
                            class="ml-auto"
                            size="x-large"
                            @click="store.handleSave()"
                        ></v-btn>
                    </template>
                </v-card>
            </v-col>

            <v-col cols="12" md="5">
                <v-card>
                    <v-toolbar color="deep-purple accent-4" justify="between">
                        <v-toolbar-title>Cart</v-toolbar-title>
                        <p class="font-weight-bold mr-5" v-if="totalCartValue > 0">${{ totalCartValue }}</p>
                    </v-toolbar>
                    <v-card-text>
                        <v-list>
                            <v-list lines="one">

                                <v-list-item
                                    v-for="product in preOrderForm.products"
                                    :key="product.name"
                                    :title="product.name"
                                >
                                    <template v-slot:prepend>
                                        <v-avatar color="grey-lighten-1" style="border-radius: 5px">
                                            <v-img :src="product.image"></v-img>
                                        </v-avatar>


                                    </template>

                                    <template v-slot:append>
                                        <v-icon>mdi-chevron-left</v-icon>
                                        <p class="font-weight-bold">{{ product.quantity }}</p>
                                        <v-icon>mdi-chevron-right</v-icon>

                                        <p class="font-weight-bold mx-3">${{ product.price }}</p>

                                        <v-btn
                                            color="grey-lighten-1"
                                            icon="mdi-close"
                                            variant="text"
                                            @click="store.removeCart(product.id)"
                                        ></v-btn>
                                    </template>
                                </v-list-item>
                            </v-list>
                        </v-list>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<style>

</style>
