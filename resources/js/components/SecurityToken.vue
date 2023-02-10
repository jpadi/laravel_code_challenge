<template>
    <application>
        <template v-slot:content>
            <v-container class="pa-4" fluid>
                <v-card :loading="loading">

                    <v-alert border="top" color="green" dismissible dark v-model="success">
                      Success
                    </v-alert>

                    <v-alert border="top" color="red" dismissible dark v-model="error">
                     Some urls cant not be created. Please review the urls on the form
                    </v-alert>

                    <v-card-title>
                        Add Urls
                    </v-card-title>
                    <v-card-text>
                        <v-text-field
                            v-model="token"
                            filled
                            label="Token"

                            hint="Enter the token"
                            persistent-hint
                        />
                    </v-card-text>

                    <v-card-actions>
                        <v-btn color="primary" width="100%" @click="handleSave">
                            Save
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-container>
        </template>
    </application>
</template>

<script>

export default {
    name: "SecurityToken",
    mounted() {
        this.token = localStorage.getItem('token');
    },
    data() {
        return {
            loading: false,
            token: '',
            error: false,
            success: false
        }
    },
    methods: {
        async handleSave() {
            localStorage.setItem('token', this.token);
            this.success = true
        }
    }
}
</script>
