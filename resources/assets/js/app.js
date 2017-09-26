
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import Router from './routes'
import Vue from 'vue';
import VeeValidate from 'vee-validate';

Vue.use(VeeValidate);

Vue.directive('tip', {
    "twoWay": true,
    bind: function(el, binding, vnode) {
        $(el).tooltip()
    }
});

Vue.directive('select', {
    twoWay: true,
    bind: function (el, binding, vnode) {
        $(el).select2().on("select2:select", (e) => {
            el.dispatchEvent(new Event('change', { target: e.target }));
        });
    },
});

Vue.directive('pick', {
    "twoWay": true,
    bind: function(el, binding, vnode) {
        $(el).datepicker({
            format: "yyyy-mm-dd",
            autoclose: true,
            todayHighlight: true
        }).on('changeDate', function(e) {
            el.dispatchEvent(new Event('input', { target: e.target }))
        });
    },
});

Vue.directive('modal', {
    "twoWay": true,
    bind: function(el, binding, vnode) {
        $(el).on('show.bs.modal', function(e) {
            el.dispatchEvent(new Event('showModal', { target: e.target }))
        });
        $(el).on('hidden.bs.modal', function(e) {
            el.dispatchEvent(new Event('hideModal', { target: e.target }))
        });
    },
});

Vue.directive('table', {
    "twoWay": true,
    bind: function(el, binding, vnode) {
        $(el).treetable();
    },
});

Vue.directive('auto', {
    "twoWay": true,
    bind: function (el, binding, vnode) {
        var type = $(el).attr('data-type');
        var target = $(el).attr('data-target');
        $(el).autocomplete({
            source: function (request, resp) {
                axios.get('/api/references/' + type, {
                    params: {
                        term: request.term
                    }
                }).then(response => {
                    resp(response.data);
                })
            },
            minLength: 2,
            select: function(event, ui) {
                $(target).val(ui.item.value);
                el.dispatchEvent(new Event('selected', {target: event.target}))
            }
        });
    }
});

const app = new Vue({
    el: '#app',
    router: Router,
    data() {
        return {
            journals: []
        }
    },
    mounted()
    {
        this.fetchJournal()
    },
    methods: {
        fetchJournal()
        {
            axios.get('/api/journal/lists/root').then(response => {
                this.journals = response.data.lists
            })
        }
    }
});
