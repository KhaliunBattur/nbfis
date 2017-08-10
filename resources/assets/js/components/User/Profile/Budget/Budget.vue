<template>
    <div class="col-lg-6">
        <h4>Өрхийн орлого</h4>
        <table v-bind:class="loading ? 'loading table table-bordered' : 'table table-bordered'">
            <tbody>
            <tr>
                <td><span class="text text-black">#</span></td>
                <td>
                    <input type="text" class="form-control input-sm" v-auto data-type="budged" v-model="budget.name" data-target="#budget-input" v-on:selected="setData(budget, '#budget-input')">
                    <input type="hidden" v-model="budget.name" id="budget-input" />
                </td>
                <td><input type="text" class="form-control input-sm" v-model="budget.budget"></td>
                <td>
                    <button class="btn btn-sm btn-success" @click="addBudget()"><i class="fa fa-plus-circle"></i></button>
                </td>
            </tr>
            <tr v-for="(b, index) in budgets">
                <td><span class="text text-black">{{ index + 1 }}</span></td>
                <td>
                    <input type="text" class="form-control input-sm" v-auto data-type="budged" :data-target="'#budget-input' + b.id" :value="b.name" v-on:selected="setData(b, '#budget-input' + b.id)">
                    <input type="hidden" v-model="b.name" :id="'budget-input' + b.id" />
                </td>
                <td><input type="text" class="form-control input-sm" v-model="b.budget"></td>
                <td>
                    <div class="btn-group">
                        <button class="btn btn-sm btn-warning" @click="saveBudget(b)"><i class="fa fa-pencil"></i></button>
                        <delete-confirm :item="user" :url="'/api/user/' + user.id + '/budget/' + b.id + '/destroy'" :styleClass="'btn btn-sm btn-danger'" v-on:destroyed="destroyBudget(b)"></delete-confirm>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>

    import DeleteConfirm from '../../../Helper/DeleteConfirm.vue';

    export default {

        props: ['user'],

        data()
        {
            return {
                budgets: [],
                budget: {
                    name: null,
                    budget: null
                },
                loading: true,
            }
        },

        components: {
            'delete-confirm': DeleteConfirm,
        },

        mounted()
        {
            this.fetchBudget();
        },

        methods: {
            setData(budget, element)
            {
                budget.name = $(element).val();
            },
            destroyBudget(budget)
            {
                this.budgets.splice(this.budgets.indexOf(budget), 1);
            },
            saveBudget(budget)
            {
                var self = this;
                this.loading = true;
                axios.patch('/api/user/' + this.user.id + '/budget/' + budget.id, budget).then(response => {
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
            addBudget()
            {
                var self = this;
                this.loading = true;
                axios.post('/api/user/' + this.user.id + '/budget', this.budget).then(response => {
                    if (response.data.result) {
                        this.fetchBudget();
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
            fetchBudget()
            {
                axios.get('/api/user/' + this.user.id + '/budget').then(response => {
                    this.budgets = response.data.model;
                    this.loading = false;
                }).catch(errors => {
                    this.loading = false;
                })
            }
        }

    }

</script>