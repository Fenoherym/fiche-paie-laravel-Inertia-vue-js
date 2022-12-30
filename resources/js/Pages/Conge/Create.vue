<template>
    <div>
        <div class="alert alert-danger" v-if="Object.keys(errors).length != 0">
            <ul>
                <li v-for="error,index in errors" :key="index">{{ error }}</li>
            </ul>
        </div>
        <div class="_card">
            <div class="card">
                <div class="card-header">
                    Ajout d'un congé
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">Choisir un employé</label>
                                <select class="form-select" id="departement" @change="getPersonnel($event)">
                                    <option>--</option>
                                    <option  v-for="personnel in personnels" :key="personnel.id" :value="personnel.id" > {{personnel.name +' ' + personnel.first_name}}</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">nombre congé max</label>
                                <input type="number" min="2022" max="2100" class="form-control" v-model="form.nbr_conge" disabled>
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
                            <button class="btn btn-primary" @click="createConge">Enregistrer</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Inertia } from "@inertiajs/inertia"
import { ref } from "@vue/reactivity"


    const props = defineProps(['personnels', 'errors'])
    const form = ref({
        personnel_id: '',
        year: new Date().getFullYear(),
        date_depart: '',
        date_arrive: '',
        nbr_conge: ''

    })

    const getPersonnel = (event) => {
        form.value.personnel_id = event.target.value
        let personnel = props.personnels.find(
            personnel => form.value.personnel_id = personnel.id
        )

        form.value.nbr_conge = personnel.nbr_conge
    }

    const createConge = () => {
        let formData = new FormData()
        formData.append("personnel_id", form.value.personnel_id)
        formData.append("year", form.value.year)
        formData.append("date_depart", form.value.date_depart)
        formData.append("date_arrive", form.value.date_arrive)
        formData.append("nbr_conge", form.value.nbr_conge)
        formData.append("isAdmin", true)
        let url = '/conge/store'

        Inertia.post(url, formData)
        form.value.date_depart = ''
        form.value.date_arrive = ''

    }

</script>

<style soped>

</style>
