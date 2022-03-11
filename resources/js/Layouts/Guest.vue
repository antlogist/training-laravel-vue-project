<template>
    <v-app>
        <v-main style="height: 100vh;" class="align-center">
            <v-card max-width="344" class="mx-auto" elevation="0">
                <div class="text-center">
                    <Link href="/">
                        <BreezeApplicationLogo style="max-width:225px" />
                    </Link>
                </div>

                <v-card-text>
                    <slot />
                </v-card-text>
            </v-card>
        </v-main>
    </v-app>
</template>

<script>
import BreezeApplicationLogo from '@/Components/ApplicationLogo.vue'
import { Link } from '@inertiajs/inertia-vue3';

export default {
    components: {
        BreezeApplicationLogo,
        Link,
    }
}
</script>
