<template>
    <form id="news-form">
        <div class="input">
            <input type="email" name="news-email" id="news-email" aria-label="S'inscrire à notre newsletter" placeholder="S'inscrire à notre newsletter">
            <input type="submit" value="S'inscrire">    
        </div>
        <div class="checkbox">
            <input type="checkbox" name="news-checkbox" id="news-checkbox">
            <label for="news-checkbox">En soumettant ce formulaire, j'accepte que mes données soient transmises à des fins de marketing. Le formulaire est sécurisé à l'aide de Google ReCaptcha.</label>
        </div>
    </form>    
</template>

<script>
    export default {
        
    };
</script>