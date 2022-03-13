<template>
    <Head title="Log in" />

    <BreezeValidationErrors class="mb-4" />

    <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
        {{ status }}
    </div>

    <v-form @submit.prevent="submit">
        <v-text-field
            v-model="form.email"
            :rules="emailRules"
            label="E-mail"
            autofocus
            autocomplete="username"
            required
            v-on:keyup.enter="submit"
        ></v-text-field>

        <v-text-field
            v-model="form.password"
            :append-icon="showPass ? 'mdi-eye' : 'mdi-eye-off'"
            :rules="required"
            :type="showPass ? 'text' : 'password'"
            name="password"
            label="Password"
            @click:append="showPass = !showPass"
            v-on:keyup.enter="submit"
        ></v-text-field>

        <v-checkbox
            v-model:checked="form.remember"
            name="remember"
            label="Remember me"
        ></v-checkbox>

        <div class="d-flex justify-space-between mt-4">
            <Link v-if="canResetPassword" :href="route('password.request')" class="text-decoration-none">
                <v-btn variant="text" size="small" class="text-black">Forgot your password?</v-btn>
            </Link>

            <v-btn color="black" size="small" variant="outlined" @click.prevent="submit">Log in</v-btn>
        </div>
    </v-form>

</template>

<script>
import BreezeGuestLayout from '@/Layouts/Guest.vue'
import BreezeValidationErrors from '@/Components/ValidationErrors.vue'
import { Head, Link } from '@inertiajs/inertia-vue3';

export default {
    layout: BreezeGuestLayout,

    components: {
        BreezeValidationErrors,
        Head,
        Link,
    },

    props: {
        canResetPassword: Boolean,
        status: String,
    },

    data() {
        return {
            showPass: false,
            form: this.$inertia.form({
                email: '',
                password: '',
                remember: false
            }),
            emailRules: [
                v => !!v || 'E-mail is required',
                v => /.+@.+/.test(v) || 'E-mail must be valid',
            ],
            required: value => !!value || 'Required.'
        }
    },

    methods: {
        submit() {
            this.form.post(this.route('login'), {
                onFinish: () => this.form.reset('password'),
            })
        }
    }
}
</script>
