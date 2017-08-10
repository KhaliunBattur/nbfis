<template>

    <div class="box">
        <div class="box-body">

            <budget-list :user="user"></budget-list>

            <expense-list :user="user"></expense-list>
        </div>
    </div>

</template>

<script>

    import Budget from './Budget.vue';
    import Expense from './Expense.vue';

    export default {

        props: ['user'],

        components: {
            'budget-list': Budget,
            'expense-list': Expense
        }

    }

</script>