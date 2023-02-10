<template>
    <application>
        <template v-slot:content>
            <v-container class="pa-4" fluid>

                <v-alert border="top" color="red" dismissible dark v-model="error">
                    {{ errorMessage }}
                </v-alert>

                <v-card>
                    <v-card-title>
                        Urls
                        <div class="flex-grow-1"/>
                        <v-text-field
                            v-model="search"
                            append-icon="mdi-magnify"
                            label="Search"
                            single-line
                            hide-details
                            @input="handleSearch"
                        />
                    </v-card-title>
                    <v-data-table
                        :headers="headers"
                        :items="urls"
                        :loading="loading"
                        hide-default-footer
                        disable-sort
                    >
                        <template v-slot:body="{ items }">
                            <tbody>
                            <tr v-for="item in items" :key="item.id">
                                <td>{{ item.url }}</td>
                                <td>{{ item.shortUrl }}</td>
                                <td>
                                    <v-btn icon @click="handleDelete(item.id)">
                                        <v-icon>mdi-delete</v-icon>
                                    </v-btn>
                                </td>
                            </tr>
                            </tbody>
                        </template>
                    </v-data-table>
                </v-card>
                <v-btn
                    fab
                    color="primary"
                    bottom
                    right
                    absolute
                    to="/url/add"
                >
                    <v-icon>mdi-plus</v-icon>
                </v-btn>
            </v-container>
        </template>
    </application>
</template>

<script>
import axios from 'axios';

export default {
    name: "url",
    data() {
        return {
            loading: false,
            search: '',
            headers: [
                {text: 'Url', value: 'url',},
                {text: 'Short url', value: 'shortUrl'},
                {text: 'Actions'}
            ],
            urls: [],
            error : false,
            errorMessage: ""
        }
    },
    mounted() {
        this.fetchUrls();
    },
    methods: {
        showError(message) {
            let  self = this;
            this.errorMessage = message
            this.error = true;
            setTimeout(function() {
                self.error = false
            }, 5000)
        },
        async fetchUrls() {
            try {
                this.loading = true;
                const response = await axios
                    .create({
                        headers:{
                            Authorization: "Bearer " + localStorage.getItem('token')
                        }
                    })
                    .get('/api/url?text=' + this.search);
                const responseContent = response.data
                this.urls = responseContent.data;
            } catch (e) {
                this.showError("Error loading url. Check bearer token")
            } finally {
                this.loading = false;
            }
        },
        handleSearch(value) {
            this.search = value
            this.fetchUrls()
        },
        async handleDelete(id) {
            this.showError("Not implemented. Was not a requirement :)")
        }
    }
}
</script>
