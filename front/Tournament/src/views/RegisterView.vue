<template>
  <div class="flex min-h-full flex-1 flex-col justify-center px-6 py-12 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
      <img class="mx-auto h-10 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt="Your Company" />
      <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Créer un compte</h2>
    </div>

    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
      <form class="space-y-6" @submit.prevent="handleSubmit">

        <div>
          <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Nom</label>
          <div class="mt-2">
            <input v-model="name" id="name" name="name" type="text" autocomplete="name" required class="pl-2 focus:outline-none block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
          </div>
        </div>

        <div>
          <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Adresse email</label>
          <div class="mt-2">
            <input v-model="email" id="email" name="email" type="email" autocomplete="email" required placeholder="JohnDoe@exemple.com" class="pl-2 focus:outline-none block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
          </div>
        </div>

        <div>
          <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Mot de passe</label>
          <div class="mt-2">
            <input v-model="password" id="password" name="password" type="password" autocomplete="new-password" required class="pl-2 focus:outline-none block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
          </div>
        </div>

        <div>
          <label for="password2" class="block text-sm font-medium leading-6 text-gray-900">Confirmer votre mot de passe</label>
          <div class="mt-2">
            <input v-model="confirmPassword" id="password2" name="password2" type="password" autocomplete="new-password" required class="pl-2 focus:outline-none block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
          </div>
        </div>

        <div>
          <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">S'inscrire</button>
        </div>
      </form>

      <div class="mt-4 text-center">
        <NavLink to="/login" class="mt-4 bg-transparent text-black">Ou se connecter</NavLink>
      </div>

      <div v-if="isSuccess" class="mt-4">
        <p class="text-center text-indigo-600 font-bold">{{ message }}</p>
      </div>
    </div>
  </div>
</template>

<script>
import HeaderComponent from '../components/HeaderComponent.vue';
import { ref } from "vue";
import axios from "axios";
import _const from "@/const.js";
import router from '@/router';
import NavLink from "@/components/NavLink.vue";

export default {
  components: {NavLink, HeaderComponent },
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
                    name: name.value,
                    is_verified: false
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

