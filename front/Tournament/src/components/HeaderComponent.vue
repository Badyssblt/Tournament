<template>
  <header class="px-[5%] py-8">
    <menu>
        <div class="nav-title">
            <router-link to="/">Tournament</router-link>
        </div>
        <div class="nav-content">
            <router-link to="/login" id="connect" v-if="!isLog">Se connecter</router-link>
            <div class="account" v-else>
                <router-link to="/dashboard" id="connect" >Dashboard</router-link>
                <div class="notify">
                <button @click="showNotify"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="#757de8" d="M224 0c-17.7 0-32 14.3-32 32V51.2C119 66 64 130.6 64 208v18.8c0 47-17.3 92.4-48.5 127.6l-7.4 8.3c-8.4 9.4-10.4 22.9-5.3 34.4S19.4 416 32 416H416c12.6 0 24-7.4 29.2-18.9s3.1-25-5.3-34.4l-7.4-8.3C401.3 319.2 384 273.9 384 226.8V208c0-77.4-55-142-128-156.8V32c0-17.7-14.3-32-32-32zm45.3 493.3c12-12 18.7-28.3 18.7-45.3H224 160c0 17 6.7 33.3 18.7 45.3s28.3 18.7 45.3 18.7s33.3-6.7 45.3-18.7z"/></svg></button>
                <notify-component :user="user" v-if="notify.length > 0" :notify="notify" v-show="isShow"/>
                </div>
            </div>
        </div>
    </menu>
  </header>
</template>

<script>
import { onBeforeMount, onMounted, ref, watch } from 'vue';
import { jwtDecode } from "jwt-decode";
import NotifyComponent from './NotifyComponent.vue';
import axios from "axios";
import _const from "@/const.js";
import eventBus from "@/eventBus.js";

export default {
  components: { NotifyComponent },
  name: "Header",
  setup() {
    const token = ref(localStorage.getItem('token'));
    const isLog = ref(false);
    const user = ref(null);
    const isShow = ref(false);
    const notify = ref([]);

    const showNotify = () => {
      isShow.value = !isShow.value;
    };

    onMounted(() => {
      checkLoginStatus()
    })

    const retrieveNotifyFromLocalStorage = async () => {
      const storedNotify = localStorage.getItem('notify');
      if (storedNotify) {
        notify.value = JSON.parse(storedNotify);
      } else {
        await getNotify();
      }
    };

    const getNotify = async () => {
      if (token.value) {
        try {
          const res = await axios({
            url: _const.axios + "/teamJoinRequests/get",
            headers: {
              'Content-Type': _const.content,
              'Authorization': 'Bearer ' + token.value
            }
          });
          notify.value = res.data;
          localStorage.setItem('notify', JSON.stringify(res.data));
        } catch (error) {
          console.error("Erreur lors de la récupération des notifications", error);
        }
      }
    };

    const checkLoginStatus = () => {
      const currentToken = localStorage.getItem('token');
      if (currentToken) {
        try {
          const decoded = jwtDecode(currentToken);
          const expirationDate = new Date(decoded.exp * 1000);
          if (expirationDate > new Date()) {
            isLog.value = true;
            user.value = decoded.email;
          } else {
            isLog.value = false;
            localStorage.removeItem('token');
          }
        } catch (error) {
          isLog.value = false;
        }
      } else {
        isLog.value = false;
      }
    };



    eventBus.on('tokenChanged', (newToken) => {
      token.value = newToken;
      console.log('Token changé via EventBus :', newToken);
      checkLoginStatus();
    });

    return {
      isLog,
      user,
      isShow,
      showNotify,
      notify
    };
  }
};
</script>


<style scoped>
    header {
        grid-column: 2 / 12;
    }

    svg {
        width: 20px;
        height: 20px;
    }

    button {
        background: none;
        border: none;
        cursor: pointer;
    }
    menu {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        padding-left: 0;
    }
    a {
        color: var(--text-color);
    }

    .account {
        display: flex;
        flex-direction: row;
        align-items: center;
        gap: 20px;
    }

    .notify {
        position: relative;
    }

    .nav-content {
        display: flex;
        flex-direction: row;
        gap: 10px;
    }
    #connect {
        padding: 10px;
        color: var(--background-color);
        background-color: var(--secondary-color);
        border-radius: 20px;
        border: 2px solid transparent;
        padding: 5px 15px;
        cursor: pointer;
        transition: all .3s ease;
    }

    #connect:hover {
        border: 2px solid var(--primary-color);
        background: none;
        color: var(--primary-color);
    }

</style>