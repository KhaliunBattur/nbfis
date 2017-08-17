<template>
    <div class="list-tree-view-parent">

        <group-form-editor :group="group" :title="title" v-modal :id="'groupForm' + account.id"></group-form-editor>

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
                <button class="btn btn-xs btn-warning" @click="editGroup(account)"><i class="fa fa-pencil"></i></button>
                <delete-confirm :item="group" :url="'/api/account/group/' + account.id" v-on:destroyed="destroyGroup(account)"></delete-confirm>
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
                <button class="btn btn-xs btn-warning" @click="editAccount(acc)"><i class="fa fa-pencil"></i></button>
                <delete-confirm :item="acc" :url="'/api/account/' + acc.id" v-on:destroyed="destroyAccount(acc)"></delete-confirm>
            </div>
            <account-form-editor :account="selectedAccount" :title="title" v-modal :id="'accountForm' + acc.id"></account-form-editor>
        </div>
        <account-row v-for="child in account.children" v-bind:key="child.id" v-bind:account="child" :number="number + 10" v-on:destroyedGroup="deleteGroup" v-on:destroyedAccount="deleteAccount"></account-row>
    </div>
</template>

<script>

    import Row from './Row.vue';
    import GroupFrom from './Group/Form.vue';
    import DeleteConfirm from './../Helper/DeleteConfirm.vue';
    import AccountForm from './Form.vue';

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
            'delete-confirm': DeleteConfirm,
            'group-form-editor': GroupFrom,
            'account-form-editor': AccountForm
        },

        methods: {
            editAccount(account)
            {
                this.selectedAccount = account;
                $('#accountForm' + account.id).modal('show');
            },
            editGroup(group)
            {
                this.group = group;
                $('#groupForm' + group.id).modal('show')
            },
            destroyAccount(account)
            {
                this.$emit('destroyedAccount', account);
            },
            deleteAccount(account)
            {
                let i = this.account.children.map(item => item.id).indexOf(account.group.id);
                let accounts = this.account.children[i].accounts;
                accounts.splice(accounts.indexOf(account), 1);
            },
            destroyGroup(group)
            {
                this.$emit('destroyedGroup', group);
            },
            deleteGroup(group)
            {
                if(this.account.children)
                {
                    this.account.children.splice(this.account.children.indexOf(group), 1);
                }
                else
                {
                    this.$emit('destroyedGroup', group)
                }
            }
        }

    }

</script>