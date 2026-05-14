<template>
    <v-container>
        <v-row class="mb-4">
            <v-col>
                <h1 class="text-h4">Product Inventory</h1>
            </v-col>
        </v-row>
        <v-card>
            <v-card-title>
                Products
            </v-card-title>
            <v-data-table
                :headers="headers"
                :items="products"
                :loading="loading"
                class="elevation-1"
            >
                <template v-slot:item.image="{ item }">
                    <router-link :to="`/products/${item.id}`">
                        <v-img
                            :src="item.image.path"
                            width="60"
                            height="60"
                            cover
                            class="rounded"
                        />
                    </router-link>
                </template>

                <template v-slot:item.price="{ item }">
                    <router-link :to="`/products/${item.id}`">
                        <div v-if="item.price < item.base_price">
                            <span class="text-red text-decoration-line-through mr-2">
                                £{{ Number(item.base_price).toFixed(2) }}
                            </span>

                            <span class="font-weight-bold">
                                £{{ Number(item.price).toFixed(2) }}
                            </span>
                        </div>

                        <div v-else>
                            £{{ Number(item.price).toFixed(2) }}
                        </div>
                    </router-link>
                </template>
            </v-data-table>
        </v-card>
    </v-container>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const loading = ref(false)

const products = ref([])

const headers = [
    { title: 'Image', key: 'image' },
    { title: 'Name', key: 'name' },
    { title: 'Price', key: 'price' },
]

const fetchProducts = async () => {
    loading.value = true

    try {
        const response = await axios.get('/api/products')

        products.value = response.data
    } catch (error) {
        console.error('Failed to fetch products:', error)
    } finally {
        loading.value = false
    }
}

onMounted(() => {
    fetchProducts()
})
</script>