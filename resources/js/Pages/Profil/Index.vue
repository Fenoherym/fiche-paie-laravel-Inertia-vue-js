<template>
  <div>
        <div class="container col-md-8">
            <h4>Mon profil</h4>
            <div class="_card">
                <div class="card">

                </div>
            </div>
            <div class="alert alert-danger" v-if="Object.keys(errors).length !== 0">
                <ul>
                    <li v-for="error,index in errors" :key="index">{{ error }}</li>
                </ul>
            </div>
            <div v-if="$page.props.flash.success" class="alert alert-success">
                {{ $page.props.flash.success }}
            </div>
            <div class="_card mt-3" v-if="editProfil">
                <div class="card p-3">
                    <div class="row">
                        <h4>Modifier mon nom</h4>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Nom</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" v-model="name">
                        </div>
                        <div class="mb-3" v-if="isAdmin">
                            <label for="exampleInputEmail1" class="form-label">Email</label>
                            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" v-model="email">
                        </div>
                        <div class="form-group mb-3">
                            <button class="btn btn-primary" @click="updateProflName">Enregistrer</button>
                        </div>
                        <hr>
                        <h4>Modifier mot de passe</h4>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Ancien mot de passe</label>
                            <input type="password" class="form-control" id="exampleInputPassword1" v-model="ancien_password">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword2" class="form-label">Nouveau mot de passe</label>
                            <input type="password" class="form-control" :class="{ 'is-valid': isValid}" id="exampleInputPassword2" v-model="new_password">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword3" class="form-label">Confirmer nouveau mot de passe</label>
                            <input type="password" class="form-control"  :class="{ 'is-valid': isValid}" id="exampleInputPassword3" v-model="confirm_new_password">
                        </div>
                        <div class="form-group" v-if="isValidAll">
                            <button class="btn btn-primary" @click="updateProfil">Enregsitrer</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="_card mt-3 mb-5">
                <div class="card p-3">
                     <div class="user-img">
                          <img src="../../src/img/user.png" alt="user">
                    </div>
                    <div class="d-flex flex-column justify-content-center align-items-center py-3">
                        <h5>Nom: {{ user.name }}</h5>
                        <h5>Email: {{ user.email }} </h5>
                    </div>
                    <button class="btn edit" @click="editProfilToggler"><i class="fa-solid fa-pen-to-square" ></i>
                        Editer mon profil</button>
                </div>
            </div>
        </div>
  </div>
</template>

<script>
import MainLayout from '../../Layout/MainLayout.vue';
import { usePage } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
export default {
    layout: MainLayout,
    props:['errors'],
    data(){
        return{
            name: this.user.name,
            email: this.user.email,
            ancien_password: '',
            new_password: '',
            confirm_new_password: '',
            isValid: false,
            editProfil: false,
            isValidAll: false
        }
    },
    beforeCreate() {
        this.user = usePage().props.value.auth.user
    },
    updated(){
       this.verifyMdp()
       if(this.isValid && this.ancien_password){
            this.isValidAll = true
       }
    },
    methods:{
        verifyMdp(){
            if(this.new_password === this.confirm_new_password && this.new_password !== ''){
                this.isValid = true

            }else{
                this.isValid = false
            }
        },
        editProfilToggler(){
            this.editProfil ^= true
        },
        updateProfil(){
            let formData = new FormData()

            formData.append('id', this.user.id)
            formData.append('name', this.name)
            formData.append('email', this.email)
            formData.append('ancien_password', this.ancien_password)
            formData.append('new_password', this.new_password)
            formData.append('confirm_new_password', this.confirm_new_ancien_password)

            Inertia.post('/profil/update', formData);
            this.ancien_password = ''
            this.new_password = ''
            this.confirm_new_ancien_password = ''
        },
        updateProflName(){
            let formData = new FormData()

            formData.append('id', this.user.id)
            formData.append('name', this.name)
            formData.append('email', this.email)
            Inertia.post('/profil/update-name', formData);
        }
    },
    created(){
        this.user = usePage().props.value.auth.user
        this.isAdmin = this.user.role.name.toLowerCase() === 'admin'.toLowerCase();
    },
}
</script>

<style scoped>
    .user-img{
        display: flex;
        justify-content: center;
    }
    .user-img img{
        border: var(--color-dark) solid 2px;
        border-radius: 10px;
        padding: 20px;
        width: 200px;
        height: auto;
    }
    h4, h5{
        color: var(--color-dark)
    }

    ._card .card{
        position: relative;
    }
    .btn.edit{
        color: var(--color-dark);
    }
</style>
