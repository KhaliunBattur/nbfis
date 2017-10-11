<template>
    <div v-if="account.journal">
        <general v-on:saved="saveGeneral" v-on:modalHidden="hideModal" :account="account" :id="id" v-if="account.journal.form_code == '00001'"></general>
        <receivable v-on:saved="saveReceivable" v-on:modalHidden="hideModal" :account="account" :id="id" v-if="account.journal.form_code == '00002'"></receivable>
        <property v-on:saved="saveReceivable" v-on:modalHidden="hideModal" :account="account" :season="season" :id="id" v-if="account.journal.form_code == '00003'"></property>
    </div>
</template>

<script>

    import General from './Forms/General.vue';
    import Receivable from './Forms/Receivable.vue';
    import Property from './Forms/Property.vue';

    export default {

        props: ['account', 'id', 'season'],

        components: {
            'general' : General,
            'receivable' : Receivable,
            'property': Property
        },

        methods: {
            saveGeneral(data)
            {
                this.$emit('saved', data);
            },
            saveReceivable(data)
            {
                this.$emit('saved', data);
            },
            hideModal(account)
            {
                account.breakdown = account.breakdown.filter(function(breakdown){
                    return breakdown.amount > 0
                });
            },
        }

    }

</script>