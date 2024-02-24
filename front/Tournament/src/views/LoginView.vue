<template>
    <header-component/>
    <form @submit.prevent="handleSubmit">
        <p class="form-title">Se connecter</p>
        <div class="input-container">
            <label for="email">Email</label>
            <input type="text" name="email" id="email" autocomplete="off" v-model="email" class="input">
        </div>
        
        <div class="input-container">
            <label for="password">Mot de passe</label>
            <input type="password" name="password" id="password" v-model="password" class="input">
        </div>
        <button type="submit">Se connecter</button>
        
    </form>
</template>

<script>
import HeaderComponent from '../components/HeaderComponent.vue'
import axios from 'axios';
import constante from '@/const.js';
import { ref } from 'vue';
import router from '@/router';
export default {
  components: { HeaderComponent },
  name: 'Login',
  setup(){
    const email = ref('');
    const password = ref('');
    const token = localStorage.getItem('token') ? localStorage.getItem('token') : localStorage.setItem('token', '');
    const handleSubmit  = async () => {
        try {
            const res = await axios({
                method: 'post',
                url: constante.login,
                data: {
                    email: email.value,
                    password: password.value
                },
                headers: {
                    'Content-Type': constante.content
                }
            });
            localStorage.setItem('token', res.data.token);
            router.push('/');
        } catch (error) {
            
        }

   
    }

    return {
        handleSubmit,
        email,
        password
    }
  }

}
</script>

<style scoped>
    form {
        display: flex;
        flex-direction: column;
        width: 300px;
        background: var(--form-color);   
        padding: 20px;
        border-radius: 10px;
        grid-row: 2;
        grid-column: 6 / 9;
        gap: 20px;
    }

    .form-title {
        color: var(--primary-color);
        font-size: 1.2em;
        font-weight: bold;
        letter-spacing: 2px;
    }

    .input-container {
        display: flex;
        flex-direction: column;
    }

    label {
        color: var(--text-color);
    }

    .input {
        border: none;
        outline: none;
        padding: 5px 10px;
        border-radius: 20px;
        font-family: var(--font-family);
        background: var(--accent-color);
        color: var(--primary-color);
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
</style>