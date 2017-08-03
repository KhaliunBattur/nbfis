<template>
    <th>
        <span @click="toggleOrder(column)" class="linkable">{{ text }}</span>
        <span v-if="query.column === column">
            <span v-if="query.direction === 'asc'">&#8595;</span>
            <span v-if="query.direction === 'desc'">&#8593;</span>
        </span>
    </th>
</template>

<script>

    export default {

        props: ['column', 'query', 'text'],

        methods: {
            toggleOrder()
            {
                if(this.query.column === this.column)
                {
                    if(this.query.direction === 'asc')
                    {
                        this.query.direction = 'desc';
                    }
                    else
                    {
                        this.query.direction = 'asc';
                    }
                }
                else
                {
                    this.query.column = this.column;
                    if(this.query.direction === 'asc')
                    {
                        this.query.direction = 'desc';
                    }
                    else
                    {
                        this.query.direction = 'asc';
                    }
                }

                this.$emit('sorted', this.query);
            }
        }

    }

</script>