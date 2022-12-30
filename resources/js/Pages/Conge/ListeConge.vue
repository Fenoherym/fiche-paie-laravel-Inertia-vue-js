<template>
    <div>
        <h4>Liste de congés</h4>
         <div class="_card mt-3 mb-5">
             <div class="card p-3">
                 <table class="table">
                     <thead>
                         <tr>
                             <th scope="col">Nom</th>
                             <th scope="col">Jours max</th>
                             <th scope="col">Annee</th>
                             <th scope="col">Pris</th>
                             <th scope="col">Du</th>
                             <th scope="col">Au</th>
                             <th scope="col">Actions</th>
                         </tr>
                     </thead>
                     <tbody>
                         <tr v-for="conge in paginate(page_size, page_number)" :key="conge.id">
                             <td>{{ conge.personnel.name + ' ' +  conge.personnel.first_name}}</td>
                             <td>{{ conge.personnel.nbr_conge }}</td>
                             <td>{{ conge.year }}</td>
                             <td>{{ conge.pris }}</td>
                             <td>
                                 {{  conge.date_depart }}
                             </td>
                             <td>
                             {{  conge.date_arrive }}

                             </td>
                             <td>
                                <Link class="btn btn-primary me-2" :href="`/conge/edit/${conge.id}`"><i class="fa-regular fa-pen-to-square"></i></Link>
                                 <button class="btn btn-danger" @click="deleteConge(conge.id)"><i class="fa-solid fa-trash"></i></button>
                             </td>
                         </tr>

                     </tbody>
                 </table>
                 <div class="alert alert-secondary" v-if="conges.length === 0">
                    Listes vides
                </div>
             </div>
         </div>
         <Pagination :itemsPerPage="page_size" :total-items="totalItems" @change-page="changePage"/>
     </div>
 </template>

 <script setup>
    import { Link } from '@inertiajs/inertia-vue3';
    import { createToaster } from '@meforma/vue-toaster';
    import { Inertia } from '@inertiajs/inertia';
    import Pagination from '../../components/Pagination.vue'
    import { ref } from '@vue/reactivity';
    const props = defineProps(['conges'])
    const toaster = createToaster({})
    const page_size = ref(5)
    const page_number = ref(1)
    const totalItems = props.conges.length

    const deleteConge = (id) => {
        let url = `/conge/delete/${id}`

        let ok = confirm("Veuillez confirmer la supprésion")
        if(ok){
            Inertia.get(url)
            toaster.success("Congé supprimé avec succès");
        }else{
            toaster.warning("Congé non supprimé")
        }
    }

    const paginate = (page_size, page_number) => {
        return props.conges.slice((page_number - 1) * page_size, page_number * page_size);
    }

    const changePage = (page) => {
        page_number.value = page
    }

 </script>

 <style>

 </style>
