<template>
    <div class="box">
        <div class="box-header">
            <div class="box-title">
                Хөрөнгө
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="form-horizontal">
                    <div class="box-body">
                        <table v-bind:class="loading ? 'loading table table-bordered' : 'table table-bordered'">
                            <tbody>
                            <tr>
                                <td><span class="text text-black">#</span></td>
                                <td>
                                    <input type="text" class="form-control input-sm" v-auto data-type="asset" v-model="asset.name" data-target="#asset-input" v-on:selected="setData(asset, '#asset-input')" placeholder="Хөрөнгийн төрөл">
                                    <input type="hidden" v-model="asset.name" id="asset-input" />
                                </td>
                                <td><input type="number" class="form-control input-sm" v-model="asset.asset" placeholder="Дүн"></td>
                                <td>
                                    <button class="btn btn-sm btn-success" @click="addAsset()"><i class="fa fa-plus-circle"></i></button>
                                </td>
                            </tr>
                            <tr v-for="(b, index) in assets">
                                <td><span class="text text-black">{{ index + 1 }}</span></td>
                                <td>
                                    <input type="text" class="form-control input-sm" v-model="b.name" v-auto data-type="asset" :data-target="'#asset-input' + b.id" :value="b.name" v-on:selected="setData(b, '#asset-input' + b.id)">
                                    <input type="hidden" v-model="b.name" :id="'asset-input' + b.id" />
                                </td>
                                <td><input type="number" class="form-control input-sm" v-model="b.asset"></td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-sm btn-warning" @click="saveAsset(b)"><i class="fa fa-pencil"></i></button>
                                        <delete-confirm :item="user" :url="'/api/user/' + user.id + '/asset/' + b.id + '/destroy'" :styleClass="'btn btn-sm btn-danger'" v-on:destroyed="destroyAsset(b)"></delete-confirm>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import DeleteConfirm from '../../../Helper/DeleteConfirm.vue';

    export default {

        props: ['user'],

        data()
        {
            return {
                assets: [],
                asset: {
                    name: null,
                    asset: null
                },
                loading: true,
            }
        },

        components: {
            'delete-confirm': DeleteConfirm,
        },

        mounted()
        {
            this.fetchAsset();
        },

        methods: {
            setData(asset, element)
            {
                asset.name = $(element).val();
            },
            destroyAsset(asset)
            {
                this.assets.splice(this.assets.indexOf(asset), 1);
            },
            saveAsset(asset)
            {
                var self = this;
                this.loading = true;
                axios.patch('/api/user/' + this.user.id + '/asset/' + asset.id, asset).then(response => {
                    this.loading = false;
                }).catch(errors => {
                    swal({
                        title: 'Уучлаарай',
                        text: 'Амжилтгүй боллоо! Дахин оролдоно уу',
                        type: 'error'
                    }, function(){
                        self.loading = false;
                    });
                });
            },
            addAsset()
            {
                var self = this;
                this.loading = true;
                axios.post('/api/user/' + this.user.id + '/asset', this.asset).then(response => {
                    if (response.data.result) {
                        this.fetchAsset();
                        this.asset.name='';
                        this.asset.asset='';
                    }
                    this.loading = false;
                }).catch(errors => {
                    swal({
                        title: 'Уучлаарай',
                        text: 'Амжилтгүй боллоо! Дахин оролдоно уу',
                        type: 'error'
                    }, function(){
                        self.loading = false;
                    });
                });
            },
            fetchAsset()
            {
                axios.get('/api/user/' + this.user.id + '/asset').then(response => {
                    this.assets = response.data.model;
                    this.loading = false;
                }).catch(errors => {
                    this.loading = false;
                })
            }
        }

    }

</script>