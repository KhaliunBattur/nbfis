<template>
    <section class="content">
        <journal-00001 :journals="journals" :journal="journal" v-if="journal && journal.form_code === '00001'"></journal-00001>
        <journal-00002 :journals="journals" :journal="journal" v-if="journal && journal.form_code === '00002'"></journal-00002>
    </section>
</template>

<script>

    import Journal00001 from './List/journal_00001.vue';
    import Journal00002 from './List/journal_00002.vue';

    export default {

        data() {
            return {
                journal: null,
                journals: null,
            }
        },

        watch: {
            '$route': function()
            {
                this.journal = null;
                this.fetchJournal();
            }
        },

        created()
        {
            this.fetchJournal();
        },

        components: {
            'journal-00001': Journal00001,
            'journal-00002': Journal00002
        },

        methods: {
            fetchJournal()
            {
                axios.get('/api/journal/' + this.$route.params.id).then(response => {
                    this.journal = response.data.journal;
                    this.journals = response.data.codes;
                });
            }
        }

    }

</script>