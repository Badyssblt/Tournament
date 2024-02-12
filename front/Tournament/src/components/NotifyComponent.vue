<template>
  <div class="notify-container">
    <p class="notify-title">Invitation à une équipe</p>
    <div class="notify-wrapper">
        <div class="notify-item" v-for="item in notify">
            <p>{{ item.name }}</p>
            <accept-notify-component :data="item"/>
        </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import _const from "@/const.js"
import { onBeforeMount, onMounted, ref } from 'vue';
import AcceptNotifyComponent from './Notify/AcceptNotifyComponent.vue';
export default {
  components: { AcceptNotifyComponent },
    name: "NotifyComponent",
    props: {
        user: {
            required: true,
            type: String
        },
        notify: {
            required: true,
            type: Array
        }
    },
    setup(props){
        const email = props.user;
        const token = localStorage.getItem('token');
        const notify = props.notify;
        console.log(notify);
        return {
            notify
        }
    }   
}
</script>

<style scoped>

    .notify-container {
        position: absolute;
        right: 0;
        top: 35px;
        background: #1A0B0B;
        width: 300px;
        padding: 20px;
        border-radius: 20px 0px 20px 20px;
    }

    .notify-title {
        color: var(--text-color);
        font-weight: bold;
    }
    .notify-wrapper {
        display: flex;
        flex-direction: column;
        gap: 10px;
        color: black;
        margin-top: 20px;
    }

    .notify-item {
        display: flex;
        flex-direction: row;
        align-items: center;
        gap: 20px;
        background: var(--primary-color);
        border-radius: 10px;
        padding: 10px 15px;
    }
</style>