<template>
    <div class="login">
        <div class="login-form">
            <div class="logo">
                <img src="../../src/img/logo.png" alt="logo">
            </div>
            <div class="title">
                <h3>Se connecter</h3>
            </div>
            <form action="/login" method="POST">
                <input type="text" name="_token" :value="csrf" hidden>
                <div class="form-group mb-3">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" :class="{ 'is-invalid': errors.email !=null }" placeholder="votre email" name="email">
                    <div class="invalid-feedback" v-if="errors.email !=null">
                        {{ errors.email }}
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label for="email">Mot de passe</label>
                    <input type="password" class="form-control" :class="{ 'is-invalid': errors.password !=null }" placeholder="votre mot de passe" name="password">
                    <div class="invalid-feedback" v-if="errors.password !=null">
                        {{ errors.password }}
                    </div>
                </div>
                <div class="btn-connex">
                    <button type="submit" class="btn-submit">Se connecter</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return{
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    },
    props:['errors']

}
</script>

<style>
 body{
    background: var(--color-background);
    font-family: 'poppins', sans-serif;
 }

 .login{
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
 }

 .logo{
    text-align: center;
 }

 .logo img{
    width: 150px;
    height: auto;
 }

 .login-form{
    width: 450px;
    height: auto;
    background: #fff;
    padding: 25px;
    border-radius: 20px;
    box-shadow: 3px 3px 10px 0px var(--color-shadow);
    -webkit-box-shadow: 3px 3px 10px 0px var(--color-shadow);
    -moz-box-shadow: 3px 3px 10px 0px var(--color-shadow);
 }
 .login-form input{
    border:none ;
    border-bottom: 1px solid rgb(158, 71, 158);
 }
 .login-form .title,
 .login-form .btn-connex{
    display: flex;
    justify-content: center;
 }


 .login-form .btn-submit{
    border: none;
    padding: 10px;
    background: rgb(158, 71, 158);
    color: #fff;
    border-radius: 10px;
 }

</style>
