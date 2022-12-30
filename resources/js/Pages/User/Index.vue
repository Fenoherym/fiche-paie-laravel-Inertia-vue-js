<template>
  <div>
        <div class="container">
            <h4>Listes des utilisateurs</h4>
            <div class="_card">
                <div class="card">

                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-2">
                    <select class="form-select form-select" aria-label=".form-select-sm example" v-model="page_size">
                        <option value="5" selected>5</option>
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="30">30</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <input type="text" placeholder="rechercher" class="form-control mb-2" v-model="q">
                </div>
            </div>
            <div class="_card mt-3">
                <div class="card p-3">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Nom</th>
                                <th scope="col">Email</th>
                                <th scope="col">Compte</th>
                                <th scope="col">Supprimer</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="user in paginate(page_size, page_number)" :key="user.id">
                                <th scope="row">{{ user.name }}</th>
                                <td>{{ user.email }}</td>
                                <td>{{ user.role.name }}</td>
                                <td>
                                    <button class="btn btn-danger" @click="deleteUser(user.id)"><i class="fa-solid fa-trash"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="mt-3">
                <Pagination :itemsPerPage="page_size" :total-items="totalItems" @change-page="changePage"/>
            </div>
        </div>
  </div>
</template>

<script>
import MainLayout from '../../Layout/MainLayout.vue';
import { Inertia } from '@inertiajs/inertia';
import { createToaster } from '@meforma/vue-toaster';
import Pagination from '../../components/Pagination.vue'
export default {
    layout: MainLayout,
    props:['users'],
    components:{
        Pagination,
    },data(){
        return{
            page_size: 5,
            page_number: 1,
            ItemsPerPage: 1,
            totalItems: this.users.length,
            q: ''
        }
    },
    methods:{
        deleteUser(id){
            this.toaster = createToaster({})
            let url = `/user/delete/${id}`
            let ok = confirm("Souhaitez-vous vraiment supprimer cet utilisateur ?")
            if(ok){
                Inertia.get(url)
                this.toaster.success('Utilisateur supprimé');
            }else{
                this.toaster.warnin('Utilisateur non supprimé');
            }

        },
        paginate(page_size, page_number){
            return this.getFilteredUsers().slice((page_number - 1) * page_size, page_number * page_size);
        },
        changePage(page){
            this.page_number = page
            console.log(page)
        },
        getFilteredUsers(){

            let users = this.users.filter(
                user => {
                    return user.name.toLowerCase().includes(this.q.toLowerCase())
                }
            );
            this.totalItems = users.length
            return users;
        }
    },

}
</script>

<style scoped>
h4{
    color: var(--color--dark) !important;
};
</style>
