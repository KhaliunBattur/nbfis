<template>
    <select v-model="selectedValue">
        <option v-for="option in options" :value="option.id">{{ option.text }}</option>
    </select>
</template>

<script>

    export default {
        props: ['options', 'value', 'selected'],
        data() {
            return {
                values: [],
            }
        },
        computed: {
            selectedValue: {
                get: function() {
                    return this.value;
                },
                set: function(val) {

                }
            }
        },
        mounted: function() {
            var self = this;
            $(this.$el).select2({
                placeholder: 'Сонгох...',
                allowClear: true
            })
                .on('change', function(){
                    var data = {
                        value: this.value,
                        selected: self.selected
                    }
                    self.$emit('input', data)
                })
        },
        destroyed: function(){
            $(this.$el).off().select2('destroy')
        }
    }

</script>