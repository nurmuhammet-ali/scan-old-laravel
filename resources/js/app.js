// import './bootstrap'
import Vue from 'vue'
import axios from 'axios'

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

new Vue({
    el: '#app',
    data: {
        domainNameField: '',
        ipAddressField: '',
        lara: window.Lara
    },
    methods: {
        changeType(e, id) {
            let input = e.target.previousElementSibling;

            let formData = new FormData();
            formData.append('_token', document.querySelector('input[name=_token]').value);
            formData.append('id', id);
            formData.append('name', input.value);

            axios.post(this.lara.routes.typesUpdate, formData)
                 .then(response => alert(response.data))
                 .catch(exception => {
                    alert('Ýalňyşlyk ýüze çykdy, consoly gor');
                    console.error(exception);
                 });
        },
        deleteType(e, id) {
            let formData = {
                _token: document.querySelector('input[name=_token]').value,
                id: id
            };

            axios.post(this.lara.routes.typesDelete, formData)
                 .then(response => window.location.href = window.location.href)
                 .catch(exception => {
                    alert('Ýalňyşlyk ýüze çykdy, consoly gor');
                    console.error(exception);
                 });
        },
        changeVPS(e, id) {
            let input = e.target.previousElementSibling;

            let formData = new FormData();
            formData.append('_token', document.querySelector('input[name=_token]').value);
            formData.append('id', id);
            formData.append('name', input.value);

            axios.post(this.lara.routes.plansUpdate, formData)
                 .then(response => alert(response.data))
                 .catch(exception => {
                    alert('Ýalňyşlyk ýüze çykdy, consoly gor');
                    console.error(exception);
                 });
        },
        deleteVPS(e, id) {
            let formData = {
                _token: document.querySelector('input[name=_token]').value,
                id: id
            };

            axios.post(this.lara.routes.plansDelete, formData)
                 .then(response => window.location.href = window.location.href)
                 .catch(exception => {
                    alert('Ýalňyşlyk ýüze çykdy, consoly gor');
                    console.error(exception);
                 });
        },
        delayTimeOUT() {
            clearInterval(window.theTimeOUT);

            window.theTimeOUT = setTimeout(function() {
                window.location.reload(true);
            }, 15000);
        }
    },
    mounted() {
        if (this.lara.domainNameField != null) {
            this.domainNameField = this.lara.domainNameField;
        }
    }
});
