<template>
    <v-app>

        <v-app-bar color="grey-lighten-2">

            <template v-slot:prepend>
                <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
            </template>

            <v-app-bar-title>
                <Link :href="route('dashboard')" class="text-decoration-none text-black">Mnemonica</Link>
            </v-app-bar-title>

            <v-spacer></v-spacer>

            <Link :href="route('logout')" method="post" as="button">
                <v-btn icon>
                    <v-icon>mdi-logout</v-icon>
                </v-btn>
            </Link>

        </v-app-bar>

        <v-navigation-drawer v-model="drawer" temporary>

            <v-list-item
            prepend-avatar="https://randomuser.me/api/portraits/men/78.jpg"
            :title="$page.props.auth.user.name"
            ></v-list-item>

            <v-divider></v-divider>

            <v-list density="compact" nav>
                <v-list-item prepend-icon="mdi-view-dashboard" title="Dashboard" @click="goToPage('dashboard')"></v-list-item>
                <v-list-item prepend-icon="mdi-forum" title="Map" @click="goToPage('map')"></v-list-item>
                <v-list-item prepend-icon="mdi-forum" title="Notes" @click="goToPage('notes')"></v-list-item>
                <v-list-item prepend-icon="mdi-forum" title="Categories" @click="goToPage('categories')"></v-list-item>
                <v-list-item prepend-icon="mdi-forum" title="Subcategories" @click="goToPage('subcategories')"></v-list-item>
            </v-list>

        </v-navigation-drawer>

        <v-main>
            <slot />
        </v-main>

    </v-app>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';

export default {
    components: {
        Link,
    },

    data() {
        return {
            drawer: null,
        }
    },
    methods: {
        goToPage(page) {
            Inertia.visit(page, {
                method: 'get',
                replace: true,
            });
        }
    }
}
</script>
