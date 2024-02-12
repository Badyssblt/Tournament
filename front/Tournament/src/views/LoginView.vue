<template>
    <header-component/>
    <form @submit.prevent="handleSubmit">
        <p class="form-title">Se connecter</p>
        <div class="input-container">
            <label for="email">Email</label>
            <input type="text" name="email" id="email" autocomplete="off" v-model="email">
        </div>
        
        <div class="input-container">
            <label for="password">Mot de passe</label>
            <input type="password" name="password" id="password" v-model="password">
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
        background: rgb(26, 11, 11);   
        padding: 20px;
        border-radius: 10px;
        grid-row: 2;
        grid-column: 6 / 9;
        gap: 20px;
    }

    .form-title {
        color: white;
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

    input {
        border: none;
        outline: none;
        padding: 5px 10px;
        font-family: var(--font-family);
        background: var(--primary-color);
    }
</style>