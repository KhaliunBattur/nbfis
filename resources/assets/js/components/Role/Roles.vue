<template>
    <div>
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Хэрэглэгчийн эрхийн зохицуулалт
            </h1>
            <ol class="breadcrumb">
                <li><router-link to="/"><i class="fa fa-dashboard"></i> Удирдлага</router-link></li>
                <li class="active">Эрхийн зохицуулалт</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li v-for="(role, index) in roles" v-bind:class="active == index ? 'active' : ''">
                                <a v-bind:href="'#tab_' + index" data-toggle="tab" @click="selectTab(role)">{{ role.display_name }}</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div v-for="(role, index) in roles" v-bind:class="active == index ? 'tab-pane active' : 'tab-pane'" v-bind:id="'tab_' + index">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th style="width: 10px">
                                            <input type="checkbox" />
                                        </th>
                                        <th>Нэр</th>
                                        <th class="action-controls-sm"></th>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <v-select v-model="selected" multiple :debounce="250" :on-search="searchPermission" :options="permissions" label="display_name" placeholder="Эрх хайх..."></v-select>
                                        </td>
                                        <td>
                                            <button class="btn btn-default" @click="addPermission">Нэмэх</button>
                                        </td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="perm in role.perms">
                                        <td><input type="checkbox" /></td>
                                        <td>{{ perm.display_name }}</td>
                                        <td>
                                            <delete-confirm :item="perm" :url="'/api/roles/' + role.id + '/permission/' + perm.id" v-on:destroyed="destroy(role, perm)"></delete-confirm>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>

    import DeleteConfirm from './../Helper/DeleteConfirm.vue';
    import vSelect from 'vue-select'

    export default {

        data()
        {
            return {
                roles: [],
                role: null,
                active: 0,
                selected: null,
                permissions: []
            }
        },

        components: {
            'delete-confirm': DeleteConfirm,
            'v-select': vSelect
        },

        created()
        {
            this.fetchRoles();
        },

        methods: {
            selectTab(role)
            {
                this.role = role;
            },
            fetchRoles()
            {
                var self = this;
                axios.get('/api/roles').then(response => {
                    this.roles = response.data.model
                    if(this.roles.length > 0)
                    {
                        this.role = this.roles[0];
                    }
                }).catch(function (errors) {
                    self.$router.push('/')
                })
            },
            addPermission()
            {
                axios.post('api/roles/' + this.role.id + '/permission', {_data: JSON.stringify(this.selected)}).then(response => {
                    this.fetchRoles();
                }).catch(function (error) {
                    swal('Уучлаарай!', 'Амжилтгүй боллоо!', 'error')
                })
            },
            searchPermission(search, loading)
            {
                loading(true);
                axios.get('/api/permission/search?role=' + this.role.id + '&q=' + search).then(response => {
                    this.permissions = response.data.permissions;
                    loading(false)
                })
            },
            destroy(role, perm)
            {
                role.perms.splice(role.perms.indexOf(perm), 1)
            }
        }

    }
</script>
