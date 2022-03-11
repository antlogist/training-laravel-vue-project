<template>
    <v-app>
        <Head title="Welcome" />
        <v-app-bar color="grey-lighten-2">
            <v-app-bar-title>Mnemonica</v-app-bar-title>

            <div>
                <div v-if="canLogin">

                    <Link class="text-decoration-none text-primary" v-if="$page.props.auth.user" :href="route('dashboard')">
                        <v-btn color="black" size="small" variant="outlined">Dashboard</v-btn>
                    </Link>

                    <template v-else>
                        <Link class="text-decoration-none text-primary mr-2" :href="route('login')">
                            <v-btn color="black" size="small" variant="outlined">Login</v-btn>
                        </Link>

                        <Link class="text-decoration-none text-primary" v-if="canRegister" :href="route('register')">
                            <v-btn color="black" size="small" variant="outlined">Register</v-btn>
                        </Link>
                    </template>

                </div>

            </div>

        </v-app-bar>
        <div class="d-flex align-center justify-center" style="height: 100vh;">
            <v-card color="grey-lighten-2 d-flex align-center justify-center mx-auto elevation-9" height="200px" max-width="344">
                <v-card-text>
                    <h1>Mnemonica</h1>
                </v-card-text>
            </v-card>
        </div>

    </v-app>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3';

export default {
    components: {
      Head,
      Link,
    },
    props: {
        canLogin: Boolean,
        canRegister: Boolean,
        title: String
    },
}
</script>
