<template>
    <div>
        <div class="container col-md-8">
            <div class="_card">
                <div class="card p-3">
                    <h4>Service</h4>
                    <div class="row g-3 align-items-center mb-3">
                        <div class="col-4 text-end">
                            <label for="name" class="col-form-label">Nom du service:</label>
                        </div>
                        <div class="col-md-8">
                            <input type="texte" id="name" class="form-control" aria-describedby="passwordHelpInline" v-model="service_name">
                        </div>
                    </div>
                    <div class="form-grou d-flex justify-content-center">
                        <button class="btn btn-primary" @click="addService()">Enregistrer</button>
                    </div>
                </div>
            </div>
            <div class="_card mt-3 mb-5">
                <div class="card p-3">
                    <h4>Poste de travail</h4>
                    <div class="row g-3 align-items-center mb-3">
                        <div class="col-4 text-end">
                            <label for="name" class="col-form-label">Service:</label>
                        </div>
                        <div class="col-md-8">
                            <select class="form-select" aria-label="Default select example" v-model="establishment_id">
                                <option value="">--choisir un service</option>
                                <option v-for="service in services" :key="service.id" :value="service.id">{{ service.name }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="row g-3 align-items-center mb-3">
                        <div class="col-4 text-end">
                            <label for="name" class="col-form-label">Poste de travail:</label>
                        </div>
                        <div class="col-md-8">
                            <input type="texte" id="name" class="form-control" aria-describedby="passwordHelpInline" v-model="workplace_name">
                        </div>
                    </div>
                    <div class="form-grou d-flex justify-content-center">
                        <button class="btn btn-primary" @click="addWorkplace()">Enregistrer</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import MainLayout from '../../../Layout/MainLayout.vue';
import { Inertia } from '@inertiajs/inertia';
import { createToaster } from '@meforma/vue-toaster';
export default {
    layout: MainLayout,
    props:['services'],
    data(){
        return{
            service_name: '',
            workplace_name: '',
            establishment_id: ''
        }
    },
    methods:{
        addService(){
            this.toaster = createToaster({})
            let formData = new FormData();
            formData.append("name", this.service_name)

            Inertia.post('/societe/service/store', formData)
            this.service_name= ''
            this.toaster.success("Service créé avec succès")
        },
        addWorkplace(){
            this.toaster = createToaster({})
            let formData = new FormData();
            formData.append("name", this.workplace_name)
            formData.append("establishment_id", this.establishment_id)

            Inertia.post('/societe/workplace/store', formData)
            this.workplace_name= ''
            this.toaster.success("Poste de travail créé avec succès")
        }
    }
}
</script>

<style>
h2, h6, h4{
    color: var(--color-dark);
}
</style>
