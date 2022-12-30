<template>
    <div>
        <div class="container">
            <div class="alert alert-danger" v-if="Object.keys(errors).length != 0">
                <ul>
                    <li v-for="error,index in errors" :key="index">{{ error }}</li>
                </ul>
            </div>
            <div class="_card">
                <div class="card">
                    <div class="card-header">
                        Demande de congé
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
                                <Link class="btn btn-danger me-3" href="/conges">Annuler</Link>
                                <button class="btn btn-primary" @click="askConge()">Enregistrer</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import MainLayout from '../../../Layout/MainLayout.vue'
import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/inertia-vue3';
export default {
    layout: MainLayout,
    props: ['personnel', 'errors'],
    components: [
        Link,
    ],
    data(){
        return{
            form:{
                personnel_id: this.personnel.id,
                nbr_conge: this.personnel.nbr_conge,
                year: new Date().getFullYear(),
                date_depart: '',
                date_arrive:'',
            },
        }
    },
    methods:{
        askConge(){
            let formData = new FormData()

            formData.append('nbr_conge', this.form.nbr_conge)
            formData.append('personnel_id', this.form.personnel_id)
            formData.append('year', this.form.year)
            formData.append('date_depart', this.form.date_depart)
            formData.append('date_arrive', this.form.date_arrive)
            formData.append('reste', this.form.reste)
            formData.append('isAdmin', false)

            let url = '/conge/store'
            Inertia.post(url, formData);
            this.form.year = ''
            this.form.pris = ''
            this.form.date_depart = ''
            this.form.date_arrive = ''
        }

    },
}
</script>

<style>

</style>
