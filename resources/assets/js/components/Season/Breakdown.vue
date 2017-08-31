<template>
    <div>
        <general v-on:saved="saveGeneral" :account="account" :id="id" v-if="account.journal.form_code == '00001'"></general>
        <receivable v-on:saved="saveReceivable" :account="account" :id="id" v-if="account.journal.form_code == '00002'"></receivable>
    </div>
</template>

<script>

    import General from './Forms/General.vue';
    import Receivable from './Forms/Receivable.vue';

    export default {

        props: ['account', 'id'],

        components: {
            'general' : General,
            'receivable' : Receivable
        },

        methods: {
            saveGeneral(data)
            {
                this.$emit('saved', data);
            },
            saveReceivable(data)
            {
                this.$emit('saved', data);
            }
        }

    }

</script>