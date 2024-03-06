<template>
    <div class="faq-container">
        <h2>Comment devenir Créateur</h2>
        <div class="faq-content">
            <ul>
                <li>
                    <h3><span>1. </span>Création de votre compte</h3>
                    <p>Inscrivez-vous sur le site en créant un compte. Assurez-vous de fournir des informations précises et valides.</p>
                </li>
                <li>
                    <h3><span>2. </span>Connexion à votre compte</h3>
                    <p>Connectez vous à votre compte puis accéder à votre dashboard</p>
                </li>
                <li>
                    <h3><span>3. </span>Accéder au formulaire de création de tournoi</h3>
                    <p>Dans votre dashboard, accéder à la rubrique <b>Mes tournois</b>, puis cliquez sur <b>Créer un tournoi</b></p>
                </li>
                <li>
                    <h3><span>4. </span>Remplissez le formulaire</h3>
                    <p>Remplissez le formulaire avec des informations valides, le formulaire <b>sera vérifée</b></p>
                </li>
                <li>
                    <h3><span>5. </span>Après vérification</h3>
                    <p>Après vérification, vous recevrez un mail, vous pourrez accéder au panel de votre tournoi dans votre Dashboard, dans la rubrique <b>Mes tournois</b></p>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
export default {

}
</script>

<style scoped>
    .faq-container {
        grid-column: 2 / 12;
    }
    h2 {
        background: var(--form-color);
        border-radius: 20px;
        padding: 20px;
        font-weight: bold;
    }

    h3 {
        font-weight: bold;
    }

    h3 span {
       font-size: 16px; 
    }

    .faq-content {
        display: flex;
        flex-direction: column;
        margin-top: 30px;
        padding-left: 90px;
    }

    .faq-content ul {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }
    
</style>