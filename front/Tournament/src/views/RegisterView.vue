<template>
    <header-component/>
    <form @submit.prevent="handleSubmit">
        <h2 class="title">S'inscrire</h2>
        <div class="form-input">
            <label for="name">Nom</label>
            <input type="text" name="name" id="name" autocomplete="off" class="full" v-model="name">
        </div>
        <div class="form-input">
            <label for="email">Adresse email</label>
            <input type="email" name="email" id="email" autocomplete="off" placeholder="JohnDoe@exemple.com" class="full" v-model="email">
        </div>
        <div class="form-row">
            <div class="form-input">
            <label for="password">Mot de passe</label>
            <input type="password" name="password" id="password" autocomplete="off" v-model="password">
            </div>
            <div class="form-input">
                <label for="password2">Confirmer votre mot de passe</label>
                <input type="password" name="password2" id="password2" autocomplete="off" v-model="confirmPassword">
            </div>
        </div>
        <button type="submit">S'inscrire</button>
        <router-link to="/login" class="connexion">Ou se connecter</router-link>
        <p class="warning-text" v-if="isSuccess">{{ message }}</p>
    </form>
</template>

<script>
import HeaderComponent from '../components/HeaderComponent.vue';
import { ref } from "vue";
import axios from "axios";
import _const from "@/const.js";
import router from '@/router';

export default {
  components: { HeaderComponent },
    setup(){
        const email = ref('');
        const password = ref('');
        const confirmPassword = ref('');
        const message = ref('');
        const isSuccess = ref(false);
        const name = ref('');
        const handleSubmit = async () => {
            if(password.value !== confirmPassword.value){
                isSuccess.value = true;
                message.value = 'Les mots de passes sont différents';
            }else {
                try {
                const res = await axios.post(_const.axios + '/users', {
                    email: email.value,
                    password: password.value,
                    name: name.value
                }, {
                    headers: {
                        'Content-Type': _const.content
                    }
                });
                if(res.data){
                    isSuccess.value = true;
                    message.value = 'Inscription réussie';
                    router.push('/login');
                }


                } catch (error) {
                    console.log(error);
                    if(error.response.data.status === 422){
                    isSuccess.value = true;
                    message.value = error.response.data.violations[0]['message'];
                    }
                }
            }
            
        }

        return {
            email,
            password,
            confirmPassword,
            message,
            isSuccess,
            handleSubmit,
            name
        }
    }
}
</script>

<style scoped>

    .title {
        font-weight: bold;
        color: var(--secondary-color);
        font-size: 20px;
        margin-bottom: 10px;
    }
    form {
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        gap: 20px;
        width: 600px;
        background: var(--form-color);
        padding: 20px;
        border-radius: 20px;
        grid-row: 2;
        grid-column: 2 / 12;
    }

    .full {
        width: 100%;
    }

    .form-row {
        display: flex;
        flex-direction: row;
        gap: 10px;
    }

    .form-input {
        display: flex;
        flex-direction: column;
        width: 100%;
    }


    input {
        width: 100%;
        padding-left: 5px;
        background: var(--accent-color);
        border: 2px solid transparent;
        outline: none;
        border-radius: 20px;
        font-family: var(--font-family);
        margin-top: 5px;
    }

    .connexion {
        color: var(--primary-color);
        opacity: .8;
        font-size: 12px;
        transition: all .2s ease;
        text-align: center;
    }

    .connexion:hover {
        text-decoration: underline;
        font-weight: bold;
        opacity: 1;
    }

    button{
        background: var(--primary-color);
        color: var(--background-color);
        font-family: var(--font-family);
        font-weight: bold;
        border: 2px solid transparent;
        outline: none;
        padding: 5px 10px;
        border-radius: 20px;
        transition: all .3s ease;
        cursor: pointer;
    }

    button:hover {
        border: 2px solid var(--primary-color);
        background: none;
        color: var(--primary-color);
    }
    .warning-text {
        text-align: center;
    }
</style>