<template>
    <div class="container mt-5">
        <div class="alert alert-danger" v-if="Object.keys(errors).length !== 0">
            <ul>
                <li v-for="error,index in errors" :key="index">{{ error }}</li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-2">
                <select class="form-select form-select" aria-label=".form-select-sm example" v-model="page_size">
                    <option value="5" selected>5</option>
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="30">30</option>
                </select>
            </div>
            <div class="col-md-4" v-if="isAdmin">
                <input type="text" placeholder="rechercher" class="form-control mb-2" v-model="q">
            </div>
            <div class="col-md-4">
                    <input type="month" class="form-control mb-2" v-model="mois">
                </div>
            <div class="col-md-2">
                <button @click="openAddCard()" class="btn btn-success"><i class="fa fa-plus"></i></button>
            </div>
        </div>
        <absence-card :personnels="personnels" :isActive="isActive" :absence="{}" v-if="isActive"></absence-card>
        <absence-card :personnels="personnels" :isActive="cardUpdateActive" :absence="this.absenceToUpdate" @closeCard="closeCard()" v-if="this.cardUpdateActive === true"></absence-card>
        <div class="_card mt-3">
            <div class="card">
                <div class="card-header">
                    Les absences
                </div>
                <div class="card-body">
                    <div class="table-responsive">

                        <table class="table" v-if="this.absences.length !== 0">
                            <thead>
                                <tr>

                                    <th scope="col">Nom</th>
                                    <th scope="col">Prenom</th>
                                    <th scope="col">Nombre d'absence(s)</th>
                                    <th scope="col">Mois</th>
                                    <th scope="col" v-if="isAdmin">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-if="isAdmin">
                                    <tr v-for="absence in paginate(page_size, page_number)" :key="absence.id">
                                        <th scope="row">{{ absence.personnel.name }}</th>
                                        <th scope="row">{{ absence.personnel.first_name }}</th>
                                        <td>{{ absence.nbr_absence }}</td>
                                        <td>{{ absence.mois }}</td>
                                        <td v-if="isAdmin">
                                            <button class="btn btn-primary me-2" @click="getAbsence(absence.id)"><i class="fa fa-edit"></i></button>
                                            <button @click="deleteAbsence(absence.id)" class="btn btn-danger "><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                </template>
                                <template v-else>
                                    <tr v-for="absence in getFilteredAbsence()" :key="absence.id">
                                        <th scope="row">{{ absence.personnel.name }}</th>
                                        <th scope="row">{{ absence.personnel.first_name }}</th>
                                        <td>{{ absence.nbr_absence }}</td>
                                        <td>{{ absence.mois }}</td>
                                        <td v-if="isAdmin">
                                            <button @click="deleteAbsence(absence.id)" class="btn btn-danger me-3"><i class="fa fa-edit"></i></button>
                                            <button class="btn btn-primary" @click="getAbsence(absence.id)"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                        <div class="alert alert-danger" v-if="isAdmin && getAbsences().length == 0">
                            Aucun résultats
                        </div>
                        <div class="alert alert-danger" v-if="!isAdmin && getFilteredAbsence().length == 0">
                            Aucun résultats
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
import MainLayout from '../../Layout/MainLayout.vue';
import { Link } from '@inertiajs/inertia-vue3';
import AbsenceCard from '../../components/AbsenceCard.vue'
import { Inertia } from '@inertiajs/inertia';
import { usePage } from '@inertiajs/inertia-vue3';
import Pagination from '../../components/Pagination.vue';

export default {
    layout: MainLayout,
    components: {
        Link,
        AbsenceCard,
        Pagination,
    },
    props:['absences', 'personnels', 'errors'],
    data(){
        return{
            isActive: false,
            absenceToUpdate: null,
            cardUpdateActive: false,
            page_size: 5,
            page_number: 1,
            totalItems: this.absences.length,
            q: '',
            mois: '',
        }
    },
    methods:{
        openAddCard(){
            this.isActive ^=  true
        },
        getAbsence(id){
            this.absenceToUpdate = this.absences.find(
                absence => absence.id === id
            )

            this.cardUpdateActive = true
        },
        closeCard(payload){
            this.cardUpdateActive = payload
            this.isActive = payload
        },
        deleteAbsence(id){
            Inertia.get(`/absence/${id}`)
        },
        getAbsences(){
            let absences
             absences = this.absences.filter(
                absence => {
                    return absence.personnel.name.toLowerCase().includes(this.q.toLocaleLowerCase()) && absence.mois.toLowerCase().includes(this.mois.toLowerCase())
                }
            )

            this.totalItems = absences.length

            return absences
        },
        getFilteredAbsence(){
            return this.absences.filter(
                absence => {
                    return absence.personnel.email === this.user.email && absence.mois.toLowerCase().includes(this.mois.toLowerCase())
                }
            )
        },
        paginate(page_size, page_number){
            return this.getAbsences().slice((page_number - 1) * page_size, page_number * page_size);
        },
        changePage(page){
            this.page_number = page
        },
    },
    created(){
        this.user = usePage().props.value.auth.user
        this.isAdmin = this.user.role.name.toLowerCase() === 'admin'.toLowerCase();
    },

}
</script>

<style>

</style>
