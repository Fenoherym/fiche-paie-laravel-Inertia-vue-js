<template>
    <div>
        <div class="container">
            <div class="header_links d-flex align-items-center py-3">
                <Link href="/personnels" class="me-2">Liste</Link>/
                <Link href="/personnel/create" class="me-2 ms-2">Ajouter</Link>/
            </div>

            <!-- <div class="_card mb-3">
                <div class="card">
                    <div class="card-header">Rechercher d'un employé</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" placeholder="rechercher" class="form-control" v-model="q">
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
            <!-- <div class="header">
                <Link href="/personnel/create"><span class="material-icons-sharp">add</span> Nouvelle employé</Link>
            </div> -->
            <div class="row">
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
                <div class="col-md-2">
                    <Link href="/personnel/create" class="btn btn-success"><i class="fa fa-plus"></i></Link>
                </div>
            </div>
            <div class="_card">
                <div class="card">
                    <div class="card-header">
                        Listes des employés
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Matricule</th>
                                        <th scope="col">Nom</th>
                                        <th scope="col">Prenom</th>
                                        <th scope="col">Telephone</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Actions</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="personnel in paginate(page_size, page_number)" :key="personnel.id">
                                        <th scope="row">{{ personnel.num_matricule }}</th>
                                        <td>{{ personnel.name }}</td>
                                        <td>{{ personnel.first_name }}</td>
                                        <td>{{ personnel.telephone }}</td>
                                        <td>{{ personnel.email }}</td>
                                        <td class="d-flex">
                                            <Show :personnel="getPersonnel(personnel.id)"/>
                                            <Link :href="`/personnel/edit/${personnel.id}`" class="btn btn-primary mx-2 btn-actions"><i class="fa fa-edit"></i></Link>
                                            <Link @click="deletePersonnel(personnel.id)" class="btn btn-danger btn-actions"><i class="fa fa-trash"></i></Link>
                                        </td>

                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-3">
                <Pagination :itemsPerPage="page_size" :total-items="totalItems" @change-page="changePage"/>
            </div>
        </div>
    </div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3';
import MainLayout from '../../Layout/MainLayout.vue';
import { Inertia } from '@inertiajs/inertia';
import { createToaster } from "@meforma/vue-toaster";
import Pagination from '../../components/Pagination.vue';
import Show from './Show.vue';

export default {
    layout: MainLayout,
    props:['personnels'],
    components:{
        Link,
        Pagination,
        Show,
    },
    data(){
        return{
            q: '',
            workplace_id: null,
            page_size: 5,
            page_number: 1,
            ItemsPerPage: 1,
            totalItems: this.personnels.length,
        }
    },
    methods:{
        deletePersonnel(id){
            this.toaster = createToaster({})
            let url = `/personnel/delete/${id}`
            let ok = confirm("Voluez vous vraiment supprimé cette employé ?")
            if(ok){
                Inertia.get(url)
                this.toaster.success("Employé supprimé avec succès");
            }else{
                this.toaster.warning("Employé non supprimé")
            }
        },
        getFilteredPersonnels(){
            return this.personnels.filter(
                personnel => {
                    return personnel.name.toLowerCase().includes(this.q.toLowerCase()) ||
                    personnel.first_name.toLowerCase().includes(this.q.toLowerCase())
                }
            )
        },
        paginate(page_size, page_number){
            return this.getFilteredPersonnels().slice((page_number - 1) * page_size, page_number * page_size);
        },
        getPersonnel(id){
            return this.personnels.find(
                personnel => personnel.id === id
            )
        },
        changePage(page){
            this.page_number = page
        },
    }
}


</script>

<style>
.btn-actions span{
    font-size: 18px;
}

</style>
