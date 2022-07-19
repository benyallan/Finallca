<template>
    <b-navbar 
        toggleable="md" 
        type="light" 
        variant="light"
    >
        <b-container>
            <b-navbar-brand href="#">
                <router-link :to="{ name: 'contascorrente' }">
                    {{brandtitulo}}
                </router-link>
            </b-navbar-brand>
            <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

            <b-collapse id="nav-collapse" is-nav class="justify-content-end">

                <!-- Right aligned nav items -->
                <b-navbar-nav class="ml-auto">

                    <b-nav-item-dropdown right v-if="auth">
                    <!-- Using 'button-content' slot -->
                    <template #button-content>
                        <em>{{auth.name}}</em>
                    </template>
                    <b-dropdown-item href="#">Perfil</b-dropdown-item>
                    <b-dropdown-item href="#">Sair</b-dropdown-item>
                    </b-nav-item-dropdown>
                    <b-navbar-nav v-else>
                        <b-nav-item href="#">Entrar</b-nav-item>
                        <b-nav-item href="#">Registre-se</b-nav-item>
                    </b-navbar-nav>
                </b-navbar-nav>
            </b-collapse>
        </b-container>
    </b-navbar>
</template>

<script>
import axios from 'axios'

    export default {
        data() {
            return {
                brandtitulo: process.env.MIX_APP_NAME,
                auth: null,
            }
        },
        mounted() {
            axios.get('auth')
            .then( res => {
                this.auth = res.data
            })
        }
    }
</script>