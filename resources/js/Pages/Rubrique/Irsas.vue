<template>
    <div>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#irsas">
            <i class="fa-solid fa-pen-nib"></i> Modifier valeurs de base IRSA
        </button>

        <!-- Modal -->
        <div class="modal fade" id="irsas" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modification valeurs de base IRSA</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Salaire</th>
                            <th>Taux</th>
                            <th>modifier</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="irsa, index in irsas" :key="irsa.id">
                            <td v-if="irsa.base_max !== null ">{{ irsa.base_min + ' - '  + irsa.base_max}}</td>
                            <td v-else>{{ irsa.base_min +'+'}}</td>
                            <td>{{ irsa.taux + '%' }}</td>
                            <td class="d-flex">
                                <input type="number" class="form-control me-3" v-model="this.irsaValues[index].base_min">
                                <input type="number" :disabled="irsa.base_max === null" class="form-control me-3" v-model="this.irsaValues[index].base_max">
                                <input type="number" class="form-control me-3" v-model="this.irsaValues[index].taux">

                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" id="close" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="submit"  class="btn btn-primary" @click="updateIrsasValue()">Enregistrer</button>
            </div>
            </div>
        </div>
        </div>
    </div>
</template>

<script>

import { Inertia } from '@inertiajs/inertia'

export default {
    props: ['irsas'],
    data(){
        return{
            irsaValues: []
        }
    },
    created(){
        this.irsas.forEach(irsa=>{
            this.irsaValues.push(irsa)
        })
    },
    methods:{
        updateIrsasValue(){
            let url = '/irsas/update'
            let formData = new FormData()

            formData.append("irsaValues",  JSON.stringify(this.irsaValues))

            Inertia.post(url, formData);
            this.closeModal();
        },
        closeModal(){
            let button = document.querySelector('#close');
            button.click();
        }
    }
}
</script>

<style>

</style>
