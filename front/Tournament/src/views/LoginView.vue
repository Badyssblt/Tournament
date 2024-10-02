
<template>

  <div class="flex min-h-full flex-1 flex-col justify-center px-6 py-12 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
      <img class="mx-auto h-10 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt="Your Company" />
      <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Connectez vous à votre compte</h2>
    </div>

    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
      <form class="space-y-6" @submit.prevent="handleSubmit">
        <div>
          <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email</label>
          <div class="mt-2">
            <input v-model="email" id="email" name="email" type="email" autocomplete="email" required="" class="pl-2 focus:outline-none block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
          </div>
        </div>

        <div>
          <div class="flex items-center justify-between">
            <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Mot de passe</label>
            <div class="text-sm">
              <a href="#" class="font-semibold text-indigo-600 hover:text-indigo-500">Mot de passe oublié ?</a>
            </div>
          </div>
          <div class="mt-2">
            <input v-model="password" id="password" name="password" type="password" autocomplete="current-password" required="" class="pl-2 focus:outline-none block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
          </div>
        </div>

        <div>
          <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Se connecter</button>
        </div>
      </form>
      <div>
        <NavLink to="/register" class="mt-4 bg-transparent text-black">Ou s'inscrire</NavLink>
      </div>
    </div>
    <div v-if="wrongPass" class="mt-4">
      <p class="text-center text-red-600 font-bold">Votre mot de passe ou email est incorrect</p>
    </div>
  </div>
</template>


<script>
import HeaderComponent from '../components/HeaderComponent.vue'
import axios from 'axios';
import constante from '@/const.js';
import { ref } from 'vue';
import router from '@/router';
import NavLink from "@/components/NavLink.vue";
import eventBus from "@/eventBus.js";

export default {
  components: {NavLink, HeaderComponent },
  name: 'Login',
  setup(){
    const email = ref('');
    const password = ref('');
    const message = ref('');
    const isFailed = ref(false);
    const token = localStorage.getItem('token') ? localStorage.getItem('token') : localStorage.setItem('token', '');

    const wrongPass = ref(false);
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
            eventBus.emit('tokenChanged', res.data.token);
            router.push('/');

        } catch (error) {
            if(error.response.status === 401){
              wrongPass.value = true;
            }
            if(error.response.data.userId){
                router.push('/verify/' + error.response.data.userId);
            }
        }


    }

    return {
        handleSubmit,
        email,
        password,
        isFailed,
        message,
      wrongPass
    }
  },
  title: 'Connexion'

}
</script>

