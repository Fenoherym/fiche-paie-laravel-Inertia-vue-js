<template>
    <div>

        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#listAsk">
        <i class="fa fa-list"></i> Mes demandes
        </button>

        <!-- Modal -->
        <div class="modal fade" id="listAsk" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Liste de demandes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Nom</th>
                                <th scope="col">Jours max</th>
                                <th scope="col">Annee</th>
                                <th scope="col">Demmandé</th>
                                <th scope="col">Date de demande</th>
                                <th scope="col">Du</th>
                                <th scope="col">Au</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="conge in paginate(page_size, page_number)" :key="conge.id">
                                <td>{{ conge.personnel.name + ' ' +  conge.personnel.first_name}}</td>
                                <td>{{ conge.personnel.nbr_conge }}</td>
                                <td>{{ conge.year }}</td>
                                <td>{{ conge.pris }}</td>
                                <td>{{ formatDate(conge.created_at) }}</td>
                                <td>
                                    {{  formatDate(conge.date_depart) }}
                                </td>
                                <td>
                                {{  formatDate(conge.date_arrive) }}

                                </td>
                                <td>
                                    <span class="text-success" v-if="conge.congestatut.statut.toLowerCase() === 'accordé'">{{ conge.congestatut.statut }}</span>
                                    <span class="text-danger" v-if="conge.congestatut.statut.toLowerCase() === 'refusé'">{{ conge.congestatut.statut }}</span>
                                    <span class="text-primary" v-if="conge.congestatut.statut.toLowerCase() === 'en attente'">{{ conge.congestatut.statut }}</span>

                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
                <div class="alert alert-secondary" v-if="conges.length === 0">
                    Listes vides
                </div>
                <Pagination :itemsPerPage="page_size" :total-items="totalItems" @change-page="changePage"/>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fermer</button>
            </div>
            </div>
        </div>
        </div>
     </div>
 </template>

 <script setup>
    import { Link } from '@inertiajs/inertia-vue3';
    import { createToaster } from '@meforma/vue-toaster';
    import { Inertia } from '@inertiajs/inertia';
    import Pagination from '../../../components/Pagination.vue'
    import { ref } from '@vue/reactivity';

    const props = defineProps(['conges'])
    const toaster = createToaster({})

     const page_size = ref(5)
     const page_number = ref(1)
     const totalItems = props.conges.length

     const deleteConge = (id) => {
         let url = `/conge/delete/${id}`

          let ok = confirm("Veuillez confirmer la suppréssion")
         if(ok){
             Inertia.get(url)
             toaster.success("Congé supprimé avec succès");
         }else{
             toaster.warning("Congé non supprimé")
         }
     }
     const agreeConge = (id) => {
         let url = `/conges/agree/${id}`
         Inertia.get(url)

         toaster.success("La demande a été accordé");

     }

     const paginate = (page_size, page_number) => {
         return props.conges.slice((page_number - 1) * page_size, page_number * page_size);
     }

     const changePage = (page) => {
         page_number.value = page
     }

     const formatDate = (date) => {
        return new Date(date).toLocaleDateString('fr', { weekday:"long", year:"numeric", month:"short", day:"numeric"})
    }



 </script>

 <style>

 </style>
