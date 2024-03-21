<template>
    <form id="news-form" @submit.prevent="submitNews">
        <div class="input">
            <input type="email" name="news-email" id="news-email" aria-label="S'inscrire à notre newsletter"
                placeholder="S'inscrire à notre newsletter" v-model="formData.mail" required>
            <input type="submit" value="S'inscrire">
        </div>

        <div class="checkbox d-flex">
            <input type="checkbox" name="news-checkbox" id="news-checkbox" required="Vous devez accepter le traitement de vos données selon la loi du RGPD pour confirmer votre inscription">
            <label for="news-checkbox">En soumettant ce formulaire, j'accepte que mes données soient transmises à des
                fins
                de marketing. Le formulaire est sécurisé à l'aide de Google ReCaptcha.</label>
        </div>

        <p id="news-response"></p>

        <div class="g-recaptcha" data-sitekey="6LfTXZ4pAAAAAFqfPDqZY7FImb9BJeS82BpbmWqo" data-size="invisible"></div>
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
        }
    },
    methods: {

        async submitNews() {
            const responseText = document.getElementById('news-response');
            const options = {
                method: 'POST',
                headers: {
                    accept: 'application/json',
                    'content-type': 'application/json',
                },
                body: JSON.stringify({
                    email: this.formData.mail,
                })
            };

            fetch('/apî/newsletter', options)
                .then(response => response.json())
                .then(response => {
                    console.log(response);
                    responseText.textContent = "Votre inscription a bien été prise en compte. Vous allez recevoir un e-mail pour confirmer votre inscription.";
                    responseText.classList.add('result-success');
                    responseText.classList.remove('result-danger');
                })
                .catch(err => {
                    console.error(err);
                    responseText.textContent = "Il y a eu une erreur lors de la demande d'inscription";
                    responseText.classList.add('result-danger');
                    responseText.classList.remove('result-success');
                });
        }
    }
};
</script>