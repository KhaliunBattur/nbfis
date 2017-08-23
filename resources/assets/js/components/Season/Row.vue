<template>
    <div class="list-tree-view-parent">
        <div class="list-group-item list-group-tree">
            <div class="col-lg-2 col-md-2 col-sm-3" v-bind:style="'padding-left: ' + number + 'px'">
                <b>{{ account.code }}</b>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-3">
                <b>{{ account.name }}</b>
            </div>
            <div class="col-lg-1 col-md-1 col-sm-1">

            </div>
            <div class="col-lg-1 col-md-1 col-sm-2">

            </div>
            <div class="col-lg-3 col-md-3 col-sm-2">

            </div>
            <div class="col-lg-1 col-md-1 col-sm-1">

            </div>
        </div>
        <div class="list-group-item list-group-tree" v-if="account.accounts" v-for="acc in account.accounts">
            <div class="col-lg-2 col-md-2 col-sm-3" v-bind:style="'padding-left: ' + (number + 20) + 'px'">
                {{ acc.account_number }}
            </div>
            <div class="col-lg-4 col-md-4 col-sm-3">
                {{ acc.name }}
            </div>
            <div class="col-lg-1 col-md-1 col-sm-1">
                {{ acc.type == 'active' ? 'Актив' : 'Пассив' }}
            </div>
            <div class="col-lg-1 col-md-1 col-sm-2">
                {{ acc.currency.name }}
            </div>
            <div class="col-lg-3 col-md-3 col-sm-2">
                {{ acc.journal.name }}
            </div>
            <div class="col-lg-1 col-md-1 col-sm-1">
                <input type="text" class="input-sm form-control" v-model="acc.balance" />
            </div>
        </div>
        <account-row v-for="child in account.children" v-bind:key="child.id" v-bind:account="child" :number="number + 10"></account-row>
    </div>
</template>

<script>

    import Row from './Row.vue';
    import DeleteConfirm from './../Helper/DeleteConfirm.vue';

    export default {

        name: 'account-row',

        props: ['account', 'number'],

        data()
        {
            return {
                group: {
                    id: 0,
                    code: null,
                    name: null,
                    root_id: null,
                    root: null
                },
                selectedAccount: {
                    name: null,
                    code: null,
                    group: null,
                    journal: null,
                    currency: null,
                    bank: null,
                    bank_account_number: null,
                    is_temporary: false,
                    type: 'active'
                },
                title: 'Засварлах'
            }
        },

        components: {
            'account-row': Row,
            'delete-confirm': DeleteConfirm
        },

        methods: {

        }

    }

</script>