<template>

    <v-container v-if="product">

        <v-row>

            <v-col cols="12" md="5">

                <v-img
                    :src="product.image.path"
                    height="400"
                    cover
                    class="rounded-lg"
                />

            </v-col>

            <v-col cols="12" md="7">

                <h1 class="text-h3 mb-4">
                    {{ product.name }}
                </h1>

                <p class="text-body-1 mb-6">
                    {{ product.description }}
                </p>

                <div class="mb-6">

                    <div v-if="product.price < product.base_price">

                        <span class="text-red text-decoration-line-through mr-3 text-h5">
                            £{{ Number(product.base_price).toFixed(2) }}
                        </span>

                        <span class="text-h4 font-weight-bold">
                            £{{ Number(product.price).toFixed(2) }}
                        </span>

                    </div>

                    <div v-else class="text-h4 font-weight-bold">
                        £{{ Number(product.price).toFixed(2) }}
                    </div>

                </div>

                <v-alert
                    v-if="promotion"
                    type="success"
                    variant="tonal"
                    class="mb-6"
                >

                    <strong>{{ promotion.name }}</strong>

                    <div v-if="promotion.discount_type === 'percentage'">
                        {{ promotion.value }}% off
                    </div>

                    <div v-if="promotion.discount_type === 'flat'">
                        £{{ promotion.value }} off
                    </div>

                </v-alert>

                <v-chip>
                    {{ product.category?.name }}
                </v-chip>

            </v-col>

        </v-row>

        <div class="mt-12">

            <h2 class="text-h4 mb-6">
                Related Products
            </h2>

            <v-row>

                <v-col
                    v-for="related in relatedProducts"
                    :key="related.id"
                    cols="12"
                    sm="6"
                    md="3"
                >

                    <v-card
                        :to="`/products/${related.id}`"
                        hover
                    >

                        <v-img
                            :src="related.image.path"
                            height="200"
                            cover
                        />

                        <v-card-title>
                            {{ related.name }}
                        </v-card-title>

                        <v-card-text>

                            <div
                                v-if="related.price < related.base_price"
                            >

                                <span class="text-red text-decoration-line-through mr-2">
                                    £{{ Number(related.base_price).toFixed(2) }}
                                </span>

                                <span class="font-weight-bold">
                                    £{{ Number(related.price).toFixed(2) }}
                                </span>

                            </div>

                            <div v-else>
                                £{{ Number(related.price).toFixed(2) }}
                            </div>

                        </v-card-text>

                    </v-card>

                </v-col>

            </v-row>

        </div>

    </v-container>

</template>

<script setup>

import { ref, computed, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import axios from 'axios'

const route = useRoute()

const product = ref(null)

const relatedProducts = ref([])

const promotion = computed(() => {

    if (!product.value) {
        return null
    }

    return (
        product.value.promotion
        || product.value.category?.promotion
    )
})

const fetchProduct = async () => {

    const response = await axios.get(
        `/api/products/${route.params.id}`
    )

    product.value = response.data

    fetchRelatedProducts()
}

const fetchRelatedProducts = async () => {

    const response = await axios.get('/api/products')

    relatedProducts.value = response.data.filter(p => {

        return (
            p.category_id === product.value.category_id
            && p.id !== product.value.id
        )
    })
}

onMounted(() => {
    fetchProduct()
})

</script>