<template>
    <v-app>
        <v-navigation-drawer v-model="drawer" app clipped>
            <v-list dense>
                <v-list-item to="/">
                    <v-list-item-action>
                        <v-icon>mdi-view-dashboard</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                        <v-list-item-title>Security Token</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item to="/url">
                    <v-list-item-action>
                        <v-icon>mdi-earth</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                        <v-list-item-title>Urls</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>

        <v-app-bar app clipped-left>
            <v-app-bar-nav-icon @click.stop="toggleDrawer"/>
            <v-toolbar-title>Laravel Code Challenge</v-toolbar-title>
        </v-app-bar>

        <v-content>
            <slot name="content"></slot>
        </v-content>

        <v-footer app>
            <span>Code Challenge</span>
        </v-footer>
    </v-app>
</template>

<script>

export default {
    data: () => ({
        drawer: null,
    }),
    async created() {
        this.$vuetify.theme.dark = true;

        if (!localStorage.getItem('token')) {
            localStorage.setItem("token", "{{}}");
        }

    },
    methods: {
        toggleDrawer() {
            this.drawer = !this.drawer;
        }
    }
}
</script>
