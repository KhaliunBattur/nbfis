<template>
    <select v-model="selectedValue">
        <optgroup v-for="option in options" :label="option.name">
            <option v-for="account in option.accounts" :value="account.id">{{ account.name }}</option>
        </optgroup>
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