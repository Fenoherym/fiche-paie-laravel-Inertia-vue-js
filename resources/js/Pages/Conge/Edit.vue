<template>
    <div>
        <div class="container">
            <div class="header_links d-flex align-items-center py-3 mt-3">
                <Link href="/conges" class="me-2">Liste</Link>/
            </div>
            <div class="alert alert-danger" v-if="Object.keys(errors).length !== 0">
                <ul>
                    <li v-for="error,index in errors" :key="index">{{ error }}</li>
                </ul>
            </div>
            <div class="_card">
                <div class="card">
                    <div class="_card">
                        <div class="card">
                            <div class="card-header">
                                Ajout d'un congé
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="exampleInputPassword1" v-model="form.personnel_id" hidden>
                                        <div class="mb-3">
                                            <label for="exampleInputPassword1" class="form-label">nombre de congé</label>
                                            <input type="text" class="form-control" id="exampleInputPassword1" v-model="form.nbr_conge" disabled>
                                        </div>
                                        <div class="mb-3">
                                            <label for="exampleInputPassword1" class="form-label">Annee</label>
                                            <input type="number" placeholder="YYYY" min="2022" max="2100" class="form-control" v-model="form.year">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="exampleInputPassword1" class="form-label">Date de départ</label>
                                            <input type="date" class="form-control" id="exampleInputPassword1" v-model="form.date_depart">
                                        </div>
                                        <div class="mb-3">
                                            <label for="exampleInputPassword1" class="form-label">Date d'arrivé</label>
                                            <input type="date" class="form-control" id="exampleInputPassword1" v-model="form.date_arrive">
                                        </div>
                                    </div>
                                    <div class="mb-3 d-flex justify-content-end">
                                        <button class="btn btn-primary" @click="updateConge(conge.id)">Enregistrer</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import MainLayout from '../../Layout/MainLayout.vue';
import { Link } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
export default {
    layout: MainLayout,
    props:['conge', 'errors'],
    components:{
        Link,
    },
    data(){
        return{
            form:{
                personnel_id: this.conge.personnel_id,
                nbr_conge: this.conge.personnel.nbr_conge,
                year: this.conge.year,
                pris: this.conge.pris,
                date_depart: this.conge.date_depart,
                date_arrive: this.conge.date_arrive,
                reste: this.conge.reste
            },
        }
    },
    methods:{
        updateConge(id){
            let formData = new FormData()
            formData.append('nbr_conge', this.form.nbr_conge)
            formData.append('personnel_id', this.form.personnel_id)
            formData.append('year', this.form.year)
            formData.append('pris', this.form.pris)
            formData.append('date_depart', this.form.date_depart)
            formData.append('date_arrive', this.form.date_arrive)
            this.form.reste = this.conge.personnel.nbr_conge - this.form.pris
            formData.append('reste', this.form.reste)

            let url = `/conge/update/${id}`

            Inertia.post(url, formData)
        }
    }
}
</script>

<style>

</style>
