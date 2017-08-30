<template>
    <general v-on:saved="saveGeneral" :account="account" :id="id"></general>
</template>

<script>

    import General from './Forms/General.vue';

    export default {

        props: ['account', 'id'],

        components: {
            'general' : General
        },

        methods: {
            saveGeneral(data)
            {
                this.$emit('saved', data);
            }
        }

    }

</script>