<template>
    <div>
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Хэрэглэгч
            </h1>
            <ol class="breadcrumb">
                <li><router-link to="/"><i class="fa fa-dashboard"></i> Удирдлага</router-link></li>
                <li class="active">Хэрэглэгч</li>
            </ol>
        </section>
        <transition name="slide">
            <router-view :roles="roles"></router-view>
        </transition>
    </div>
</template>

<script>
    export default {

        data()
        {
            return {
                roles: []
            }
        },

        created()
        {
            this.fetchRoles();
        },

        methods: {
            fetchRoles()
            {
                var self = this;
                axios.get('api/roles').then(response => {
                    this.roles = response.data.model
                }).catch(function (errors) {
                    self.$router.push('/')
                })
            }
        }

    }
</script>
