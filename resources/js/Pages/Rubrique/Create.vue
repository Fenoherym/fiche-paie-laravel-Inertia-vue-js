<template>
    <div>
        <div class="container">
            <div class="header_links d-flex align-items-center py-3">
                <Link href="/rubriques" class="me-2">Liste</Link>/
                <Link href="/rubrique/create" class="me-2 ms-2">Ajouter</Link>/
            </div>
            <div class="_card">
                <div class="card">
                    <div class="card-header">
                        Ajout d'un rubrique
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row g-3 align-items-center">
                                    <div class="col-3 text-end mb-3">
                                        <label for="name" class="col-form-label">Numero:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="number" id="name" class="form-control" :class="{ 'is-invalid': errors.numero != null}" aria-describedby="passwordHelpInline" v-model="form.numero">
                                        <div class="invalid-feedback" v-if="errors.numero != null">
                                            {{ errors.numero }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-items-center">
                                    <div class="col-3 text-end mb-3">
                                        <label for="name" class="col-form-label">Designation:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" id="name" class="form-control" :class="{ 'is-invalid': errors.designation != null}" aria-describedby="passwordHelpInline" v-model="form.designation">
                                        <div class="invalid-feedback" v-if="errors.designation != null">
                                            {{ errors.designation }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-items-center">
                                    <div class="col-3 text-end mb-3">
                                        <label for="name" class="col-form-label">Valeur de base:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="number" id="name" class="form-control" :class="{ 'is-invalid': errors.base != null }" aria-describedby="passwordHelpInline" v-model="form.base">
                                        <div class="invalid-feedback" v-if="errors.base != null">
                                            {{ errors.base }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-items-center">
                                    <div class="col-3 text-end mb-3">
                                        <label for="name" class="col-form-label">Taux part salarial:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="number" id="name" class="form-control"  aria-describedby="passwordHelpInline" v-model="form.taux_part_salarial">
                                        <div class="invalid-feedback">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row g-3 align-items-center">
                                    <div class="col-3 text-end mb-3">
                                        <label for="name" class="col-form-label">Taux part patronal:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="number" id="name" class="form-control" aria-describedby="passwordHelpInline" v-model="form.taux_part_patronal">
                                        <div class="invalid-feedback">

                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-items-center">
                                    <div class="col-3 text-end mb-3">
                                        <label for="name" class="col-form-label">Type:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <select class="form-select form-select-sm" aria-label=".form-select-sm example" v-model="form.type" :class="{ 'is-invalid': errors.base != null }">
                                            <option selected>------------</option>
                                            <option value="cotisations">cotisations</option>
                                            <option value="brut">brut</option>
                                            <option value="charge familiale">charge familiale</option>
                                        </select>
                                        <div class="invalid-feedback" v-if="errors.type != null">
                                            {{ errors.type }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-items-center">
                                    <div class="col-3 text-end mb-3">
                                        <label for="name" class="col-form-label">:</label>
                                    </div>
                                    <div class="col-md-9">
                                            <select class="form-select form-select-sm" :class="{ 'is-invalid': errors.isRetenue != null }" aria-label=".form-select-sm example" @change="getRetenueBool" v-model="form.isRetenue">
                                                <option value="1">Retenue</option>
                                                <option value="0">Non Retenue</option>
                                            </select>
                                            <div class="invalid-feedback" v-if="errors.isRetenue != null">
                                                {{ errors.isRetenue }}
                                            </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-items-center" v-if="!isRetenue">
                                    <div class="col-3 text-end mb-3">
                                        <label for="name" class="col-form-label">:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="0" v-model="form.isImposable">
                                            <label class="form-check-label" for="inlineRadio1">Non imposable</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="1" v-model="form.isImposable">
                                            <label class="form-check-label" for="inlineRadio2">Imposable</label>
                                        </div>
                                        <div class="invalid-feedback">

                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="form-group d-flex justify-content-end">
                                <button class="btn btn-primary" @click="postRubrique">Enregistrer</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import MainLayout from '../../Layout/MainLayout.vue'
import { Inertia } from '@inertiajs/inertia'
import { Link } from '@inertiajs/inertia-vue3'
export default {
    layout: MainLayout,
    props:['errors'],
    components:{
        Link,
    },
    data(){
        return{
            form:{
                numero:null,
                designation:'',
                base: null,
                taux_part_salarial: '',
                taux_part_patronal: '',
                type: '',
                isRetenue: 1,
                isImposable: 0

            },
            isRetenue: true
        }
    },
    methods:{
        getRetenueBool(event){
            let value = event.target.value
            console.log(value)
            if(value==0){
                this.isRetenue=false
            }else{
                this.isRetenue=true
            }
        },
        postRubrique(){
            let formData = new FormData()
            formData.append("numero", this.form.numero)
            formData.append("designation", this.form.designation)
            formData.append("base", this.form.base)
            formData.append("taux_part_salarial", this.form.taux_part_salarial)
            formData.append("taux_part_patronal", this.form.taux_part_patronal)
            formData.append("type", this.form.type)
            formData.append("isRetenue", this.form.isRetenue)
            formData.append("isImposable", this.form.isImposable)
            let url = '/rubrique/store'
            Inertia.post(url, formData)
        }
    }
}
</script>

<style>

</style>
