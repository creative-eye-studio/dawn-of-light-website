<template>
    <form id="news-form" @submit.prevent="submitForm">
        <div class="input">
            <input type="email" name="news-email" id="news-email" aria-label="S'inscrire à notre newsletter"
                placeholder="S'inscrire à notre newsletter" v-model="formData.mail">
            <input type="submit" value="S'inscrire">
        </div>
        <div class="checkbox d-flex">
            <input type="checkbox" name="news-checkbox" id="news-checkbox">
            <label for="news-checkbox">En soumettant ce formulaire, j'accepte que mes données soient transmises à des
                fins
                de marketing. Le formulaire est sécurisé à l'aide de Google ReCaptcha.</label>
        </div>

        <div class="g-recaptcha" data-sitekey="6LfTXZ4pAAAAAFqfPDqZY7FImb9BJeS82BpbmWqo"></div>

    </form>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            formData: {
                mail: ''
            },
            brevoApiKey: '',
            publicKey: '',
        }
    },
    directives: {
        recaptchaSitekey: {
            mounted(el, binding) {
                el.setAttribute('data-sitekey', binding.value);
            }
        }
    },
    mounted() {
        this.fetchBrevoApiKey();
        this.fetchGoogleApiKey();
    },
    methods: {
        async fetchBrevoApiKey() {
            try {
                const response = await fetch('/api/brevo-api');
                const data = await response.json();
                this.brevoApiKey = data.brevoApiKey;
            } catch (error) {
                console.error("Erreur lors de la récupération de l'API : ", error);
            }
        },

        async fetchGoogleApiKey() {
            try {
                const response = await axios.get('/api/recaptcha');
                this.publicKey = response.data.public;
            } catch (error) {
                console.error("Erreur lors de la récupération de la clé publique reCAPTCHA : ", error);
            }
        },

        async submitNews() {
            const options = {
                method: 'POST',
                headers: {
                    accept: 'application/json',
                    'content-type': 'application/json',
                    'api-key': this.brevoApiKey
                },
                body: JSON.stringify({
                    email: this.formData.mail,
                    includeListIds: [8],
                    templateId: 1,
                    redirectionUrl: 'http://requestb.in/173lyyx1'
                })
            };

            fetch('https://api.brevo.com/v3/contacts/doubleOptinConfirmation', options)
                .then(response => response.json())
                .then(response => console.log(response))
                .catch(err => console.error(err));
        }
    }
};
</script>