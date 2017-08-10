<template>
    <div class="col-lg-6">
        <h4>Өрхийн зарлага</h4>
        <table v-bind:class="loading ? 'loading table table-bordered' : 'table table-bordered'">
            <tbody>
            <tr>
                <td><span class="text text-black">#</span></td>
                <td>
                    <input type="text" class="form-control input-sm" v-auto data-type="expense" v-model="expense.name" data-target="#expense-input" v-on:selected="setData(expense, '#expense-input')">
                    <input type="hidden" v-model="expense.name" id="expense-input" />
                </td>
                <td><input type="text" class="form-control input-sm" v-model="expense.expense"></td>
                <td>
                    <button class="btn btn-sm btn-success" @click="addExpense()"><i class="fa fa-plus-circle"></i></button>
                </td>
            </tr>
            <tr v-for="(b, index) in expenses">
                <td><span class="text text-black">{{ index + 1 }}</span></td>
                <td>
                    <input type="text" class="form-control input-sm" v-auto data-type="expense" :data-target="'#expense-input' + b.id" :value="b.name" v-on:selected="setData(b, '#expense-input' + b.id)">
                    <input type="hidden" v-model="b.name" :id="'expense-input' + b.id" />
                </td>
                <td><input type="text" class="form-control input-sm" v-model="b.expense"></td>
                <td>
                    <div class="btn-group">
                        <button class="btn btn-sm btn-warning" @click="saveExpense(b)"><i class="fa fa-pencil"></i></button>
                        <delete-confirm :item="user" :url="'/api/user/' + user.id + '/expense/' + b.id + '/destroy'" :styleClass="'btn btn-sm btn-danger'" v-on:destroyed="destroyexpense(b)"></delete-confirm>
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
                expenses: [],
                expense: {
                    name: null,
                    expense: null
                },
                loading: true,
            }
        },

        components: {
            'delete-confirm': DeleteConfirm,
        },

        mounted()
        {
            this.fetchExpense();
        },

        methods: {
            setData(expense, element)
            {
                expense.name = $(element).val();
            },
            destroyexpense(expense)
            {
                this.expenses.splice(this.expenses.indexOf(expense), 1);
            },
            saveExpense(expense)
            {
                var self = this;
                this.loading = true;
                axios.patch('/api/user/' + this.user.id + '/expense/' + expense.id, expense).then(response => {
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
            addExpense()
            {
                var self = this;
                this.loading = true;
                axios.post('/api/user/' + this.user.id + '/expense', this.expense).then(response => {
                    if (response.data.result) {
                        this.fetchExpense();
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
            fetchExpense()
            {
                axios.get('/api/user/' + this.user.id + '/expense').then(response => {
                    this.expenses = response.data.model;
                    this.loading = false;
                }).catch(errors => {
                    this.loading = false;
                })
            }
        }

    }

</script>