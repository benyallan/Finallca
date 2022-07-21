<template>
    <div id="painel">
            <b-navbar 
            toggleable="md" 
            type="light" 
            variant="light"
        >
            <b-navbar-brand>
                <b-button v-b-toggle.painel-lateral size="sm">
                    <b-icon icon="chevron-bar-right"></b-icon>
                </b-button>
                <span class="titulo">{{brandtitulo}}</span>
            </b-navbar-brand>
            <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

            <b-collapse id="nav-collapse" is-nav class="justify-content-end">

                <!-- Right aligned nav items -->
                <b-navbar-nav class="ml-auto">

                    <b-nav-item-dropdown right v-if="auth">
                    <!-- Using 'button-content' slot -->
                    <template #button-content>
                        <strong>{{auth.name}}</strong>
                    </template>
                    <b-dropdown-item href="#">Perfil</b-dropdown-item>
                    <b-dropdown-item>
                        <a href="#" @click.prevent="logout">Sair</a>
                    </b-dropdown-item>
                    </b-nav-item-dropdown>
                    <b-navbar-nav v-else>
                        <b-nav-item href="#">Entrar</b-nav-item>
                        <b-nav-item href="#">Registre-se</b-nav-item>
                    </b-navbar-nav>
                </b-navbar-nav>
            </b-collapse>
            <div>
                <b-sidebar 
                    id="painel-lateral" 
                    backdrop
                    bg-variant="dark" 
                    text-variant="light"
                    close-label="Fechar"
                    shadow
                >
                <div class="px-3 py-2">
                     <b-nav vertical>
                        <b-nav-item>
                            <router-link to="/home">Dashboard</router-link>
                        </b-nav-item>
                        <b-nav-item v-b-toggle.contas>
                            <b-icon icon="plus"></b-icon>
                            Contas
                        </b-nav-item>
                        <b-collapse id="contas">
                            <b-card class="bg-dark border-0">
                                <b-nav vertical>
                                    <b-nav-item>
                                        <router-link to="/home/carteiras">Carteiras</router-link>
                                    </b-nav-item>
                                    <b-nav-item>
                                        <router-link to="/home/contascorrente">Contas Corrente</router-link>
                                    </b-nav-item>
                                </b-nav>
                            </b-card>
                        </b-collapse>
                    </b-nav>
                </div>
                </b-sidebar>
            </div>
        </b-navbar>
    </div>
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
            axios.get(`${process.env.MIX_BASE_URL}/auth`)
            .then( res => {
                this.auth = res.data
            })
        },
        methods: {
            logout() {
               axios.post(`${process.env.MIX_BASE_URL}/logout`).then(response => {
                  if (response.status === 302 || 401) {
                    window.location.href = "/"
                  }
                  else {
                    // throw error and go to catch block
                  }
                }).catch(error => {

              });
            }
        }
    }
</script>

<style>
    #painel {
        margin-left: 2%;
        margin-right: 2%;
    }
    div.card-body {
        padding-top: 0;
        margin-top: 0;
    }
    #painel-lateral a:link, a:visited {
        text-decoration: none;
        color: darkgrey;
    }
    #painel-lateral a:hover {
        background-color: gray;
    }
    button.close {
        background-color: inherit;
        border-radius: 25%;
    }
    .router-link-exact-active {
        background-color: gray;
        display: block;
    }
    #painel-lateral a.nav-link {
        padding: 0px;
    }
    #painel-lateral li.nav-item {
        padding: 3px;
    }
    .titulo {
        font-weight: bolder;
        font-family: Arial, Helvetica, sans-serif;
    }
</style>