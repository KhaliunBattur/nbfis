<template>
    <select>
        <option v-for="option in options" :value="option.id" :selected="value == option.id ? 'selected' : ''">{{ option.text }}</option>
    </select>
</template>

<script>

    export default {
        props: ['options', 'value', 'selected'],

        mounted: function() {
            var self = this;
            $(this.$el)
                .select2({ data: this.options })
                .trigger('change')
                // emit event on change.
                .on('change', function () {
                    var data = {
                        value: this.value,
                        selected: self.selected
                    }
                    self.$emit('input', data)
                })
        },
        destroyed: function () {
            $(this.$el).off().select2('destroy')
        }
    }

</script>