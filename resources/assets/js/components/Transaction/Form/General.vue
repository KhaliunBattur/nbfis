<template>
    <div class="modal fade" id="general_transactionModal" tabindex="-1" role="dialog" aria-labelledby="general_transactionModalLabel" v-modal v-on:showModal="init()" v-on:hideModal="hiddenModal()">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <single v-if="customers.length > 0 && accounts.length > 0 && !multiple" :accounts="accounts" :customers="customers" :to_accounts="to_accounts"></single>
                <multiple v-if="customers.length > 0 && accounts.length > 0 && multiple" :accounts="accounts" :customers="customers" :to_accounts="to_accounts"></multiple>
            </div>
            <div class="checkbox pull-left" style="color: #FFF">
                <label>
                    <input type="checkbox" v-model="multiple"> {{ check_text }}
                </label>
            </div>
        </div>
    </div>
</template>

<script>

    import Single from './Single.vue';
    import Multiple from './Multiple.vue';

    export default {

        data()
        {
            return {
                customers: [],
                accounts: [],
                to_accounts: [],
                multiple: false,
                check_text: 'Олон данс руу зэрэг бичих бол чагтлана уу'
            }
        },

        components: {
            'single' : Single,
            'multiple' : Multiple
        },

        methods: {

            init()
            {
                axios.get('/api/customer/list').then(response => {
                    this.customers = response.data.customers
                }).catch(errors => {})

                axios.get('/api/account/list').then(response => {
                    this.accounts = response.data.model
                }).catch(errors => {})
            },

            hiddenModal()
            {
                this.$emit('modalHided');
            }
        }

    }

</script>