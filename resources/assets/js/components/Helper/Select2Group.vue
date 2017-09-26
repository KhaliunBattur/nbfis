<template>
    <select class="chosen form-control" v-if="options" v-model="selectedValue">
        <option></option>
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
            $(this.$el).chosen({
                allow_single_deselect: true,
                width: '99%'
            }).on('change', function(){
                var data = {
                    value: this.value,
                    selected: self.selected
                }
                self.$emit('input', data)
            })
        },
        watch:{
            value(val){
                $(this.$el).val(val).trigger('chosen:updated');
            }
        },
        destroyed: function(){
            $(this.$el).off().chosen('destroy')
        }
    }

</script>