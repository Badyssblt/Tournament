<template>
    <div>
        <button @click="acceptNotify">Accepter</button>
    </div>
</template>

<script>
import axios from "axios";
import _const from "@/const.js";
export default {

    name: "AcceptNotifyComponent",
    props: {
        data: {
            required: true,
            type: Object
        }
    },
    setup(props){
        const user = props.data;
        console.log(user);
        const token = localStorage.getItem('token');
        const acceptNotify = async () => {
            try {
                const res = await axios({
                    url: _const.axios + "/team_join_requests/" + user.id,
                    headers: {
                        'Content-Type': _const.patchContent,
                        'Authorization': 'Bearer ' + token
                    },
                    method: "patch",
                    data: {
                        status: "accept",
                        targetTeam: "/api/teams/" + user.teamId
                    }
                });
                console.log(res);
            } catch (error) {
                console.error(error);
            }
        }

        return {
            acceptNotify
        }
    }
}
</script>

<style scoped>
    button {
        color: var(--text-color);
        font-weight: bold;
        font-family: var(--font-family);
        border: none;
        outline: none;
        padding: 5px 10px;
        border-radius: 20px;
        background: var(--secondary-color);
        transition: all .2s ease;
    }

    button:hover {
        opacity: .8;
        cursor: pointer;
    }
</style>