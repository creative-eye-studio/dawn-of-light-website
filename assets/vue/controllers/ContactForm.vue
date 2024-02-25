<template lang="fr">

        <form @submit.prevent="submitForm">
            <fieldset>
                <legend>Dis m'en plus sur toi</legend>
                <p>
                    <label for="nom">Nom *</label>
                    <input type="text" id="nom" name="nom" v-model="formData.nom" required>
                </p>

                <p>
                    <label for="prenom">Prénom *</label>
                    <input type="text" id="prenom" name="prenom" v-model="formData.prenom" required>
                </p>

                <p>
                    <label for="surnom">Surnom (Ou comment tu veux qu'on t'appelles)</label>
                    <input type="text" name="surnom" id="surnom" v-model="formData.surnom">
                </p>

                <p>
                    <label for="mail">Adresse E-Mail *</label>
                    <input type="email" id="mail" name="mail" v-model="formData.mail" required>
                </p>

                <p>
                    <label for="discord">Ton Discord (Si tu en as un)</label>
                    <input type="text" id="discord" name="discord" v-model="formData.discord">
                </p>
            </fieldset>
            <fieldset>
                <legend>Tes compétences et tes ambitions</legend>
                <p>
                    <label for="skills">Sur quel type de poste est ce que tu te sens le plus à l'aise ?</label>
                    <select name="skills" id="skills" v-model="formData.skills" required>
                        <option value="Game / Level Design">Game / Level Design</option>
                        <option value="Sound Design">Sound Design</option>
                        <option value="Programmation">Programmation</option>
                        <option value="Graphiste 2D/3D">Graphiste 2D/3D</option>
                        <option value="Gestion de projet">Gestion de projet</option>
                        <option value="Autre">Autre</option>
                    </select>
                </p>
                <p>
                    <label for="parcours">Présente ton parcours ! Juste pour savoir quelles sont tes forces et tes faiblesses :). *</label>
                    <textarea name="parcours" id="parcours" required v-model="formData.parcours"></textarea>
                </p>
                <p>
                    <label for="motivations">En quelques lignes, explique ce qui te motive à nous rejoindre et ce que tu espères de ce projet. *</label>
                    <textarea name="motivations" id="motivations" required v-model="formData.motivations"></textarea>
                </p>
                <div class="checkbox d-flex">
                    <input type="checkbox" name="contact-checkbox" id="contact-checkbox">
                    <label for="contact-checkbox">En soumettant ce formulaire, j'accepte que mes données soient transmises à des fins de relation avec l'équipe du projet. Le formulaire est sécurisé à l'aide de Google ReCaptcha.</label>
                </div>
            </fieldset>
            <p id="mail-response"></p>
            <p>
                <button type="submit" class="btn-primary-red-border">Envoyer</button>
            </p>
        </form>

</template>

<script>
import axios from 'axios';
export default {
    data() {
        return {
            formData: {
                nom: '',
                prenom: '',
                surnom: '',
                mail: '',
                discord: '',
                skills: '',
                parcours: '',
                motivations: '',
            }
        }
    },
    methods: {
        async submitForm() {
            const responseText = document.getElementById('mail-response');
            try {
                await axios.post('/contact-form', this.formData);
                responseText.textContent = "Le mail a bien été envoyé";
                responseText.classList.add('result-success');
                responseText.classList.remove('result-danger');
            } catch (error) {
                console.error("Erreur lors de la soumission du formulaire : ", error);
                responseText.textContent = "Il y a eu une erreur lors de l'envoi du mail";
                responseText.classList.add('result-danger');
                responseText.classList.remove('result-success');
            }
        }
    }
}
</script>