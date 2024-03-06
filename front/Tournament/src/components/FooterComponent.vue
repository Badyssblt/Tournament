<template>
  <footer>
    <div class="footer-container">
        <div class="footer-col">
        <h2>Informations</h2>
        <div class="footer-col__content">
            <ul>
                <li class="footer-item">Qui sommes nous</li>
                <li class="footer-item">Conditions d'utilisation</li>
            </ul>
        </div>
    </div>
    <div class="footer-col">
        <h2>FAQ</h2>
        <div class="footer-col__content">
            <ul>
                <router-link class="footer-item" to="/faq/creator">Comment devenir <b>Créateur</b></router-link>

                <li class="footer-item">Comment devenir <b>Créateur</b></li>
                <li class="footer-item">Comment créer un tournoi</li>
            </ul>
        </div>
    </div>
    <div class="footer-col">
        <h2>Nous contacter</h2>
        <form>
            <div class="form-input">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" autocomplete="off">
            </div>
            <button>Envoyer</button>
        </form>
    </div>
    </div>
    
    <h3 id="copyright">&#169; 2023 Tournament. Tous droits réservés.</h3>
  </footer>
</template>

<script>
export default {

}
</script>

<style scoped>
    footer {
        height: 180px;
        display: flex;
        flex-direction: column;
        grid-column: 1 / 13;
        background: var(--form-color);
        margin-top: 40px;
        padding: 20px 10%;
        
    }

    h2 {
        font-weight: bold;
        font-size: 20px;
        margin-bottom: 20px;
    }

    .footer-col {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    .footer-item {
        position: relative;
        margin-bottom: 10px;
    }

    .footer-item:hover {
        cursor: pointer;
        opacity: .7;
    }

    .footer-item:hover::before {
        position: absolute;
        content: "";
        left: -10px;
        width: 2px;
        height: 100%;
        background: var(--text-color);
    }

    .form-input {
        display: flex;
        flex-direction: column;
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

    input {
        border: none;
        outline: none;
        padding: 5px 10px;
        border-radius: 20px;
        font-family: var(--font-family);
        background: var(--accent-color);
        color: var(--primary-color);
        margin-bottom: 10px;
    }

    .footer-container {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
    }

    #copyright {
        font-size: 12px;
    }

</style>