<template>
    <select class="chosen form-control">
        <option></option>
        <optgroup label="Test 1">
            <option>Html</option>
            <option>Css</option>
            <option>Css3</option>
            <option>Php</option>
            <option>MySql</option>
        </optgroup>
        <optgroup label="Test 2">
            <option>Javascript</option>
            <option>Jquery</option>
            <option>Html5</option>
            <option>Wordpress</option>
            <option>Joomla</option>
            <option>Druple</option>
            <option>Json</option>
            <option>Angular Js</option>
        </optgroup>
    </select>
</template>

<script>

    export default {
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
                allow_single_deselect: true
            }).on('change', function(){

            })
        },
        destroyed: function(){
            $(this.$el).off().chosen('destroy')
        }
    }

</script>