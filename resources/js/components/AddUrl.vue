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
                        <v-textarea
                            v-model="urls"
                            filled
                            label="Urls"
                            :placeholder="'https://url1.com\nhttps://url2.com\nhttps://url3.com'"
                            hint="Enter one url per line."
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
import {trim} from "lodash/string";
import axios from "axios";

export default {
    name: "AddUrl",
    data() {
        return {
            loading: false,
            urls: '',
            error: false,
            success: false
        }
    },
    methods: {
        async handleSave() {

            this.error = false;

            let urls = this.urls.split(/\r?\n|\r|\n/g).map(e => trim(e)).filter(e => e !== "")

            let errors = [];

            for (let pos in urls) {
                let url = urls[pos]
                try {
                    await axios
                        .create({
                            headers:{
                                Authorization: "Bearer " + localStorage.getItem('token')
                            }
                        })
                        .post("/api/url", {
                        "url": url
                    })

                } catch (e) {
                    errors.push(url)
                }
            }

            // if there is some error stay here
            if (errors.length) {
                this.urls = errors.join("\n");
                this.error = true;
                return
            }

            this.success = true;

            self = this
            setTimeout(function (){
                self.$router.push("/url/")
            }, 1000)
        }
    }
}
</script>
