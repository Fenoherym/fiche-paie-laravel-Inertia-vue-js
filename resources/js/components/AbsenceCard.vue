<template>
    <div class="_card mt-3 absence" :class="{ active: is_active }">
        <div class="card">
            <div class="card-header">
                Ajout d'une absence
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row g-3 align-items-center">
                            <div class="col-3 text-end mb-3">
                                <label for="name" class="col-form-label">Employé:</label>
                            </div>
                            <div class="col-md-9">
                                <select class="form-select" id="departement" @change="getPersonnel($event)" v-model="Form.personnel_id">
                                    <option>--</option>
                                    <option  v-for="personnel in personnels" :key="personnel.id" :value="personnel.id" > {{personnel.name}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="row g-3 align-items-center">
                            <div class="col-3 text-end mb-3">
                                <label for="name" class="col-form-label">Mois:</label>
                            </div>
                            <div class="col-md-9">
                               <input type="month" class="form-control" v-model="Form.mois">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row g-3 align-items-center">
                            <div class="col-3 text-end mb-3">
                                <label for="name" class="col-form-label">Nombre d'absence:</label>
                            </div>
                            <div class="col-md-9">
                                <input type="number" class="form-control" v-model="Form.nbr_absence">
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-danger mt-3 me-3" style="width: 60px; height: 40px;" @click="closeCard()"><i class="fa-solid fa-xmark"></i></button>
                        <button class="btn btn-primary mt-3" v-if="Object.keys(absence).length == 0" style="width: 60px; height: 40px;" @click="addAbsence()"><i class="fa fa-save"></i></button>
                        <button class="btn btn-primary mt-3" v-else style="width: 60px; height: 40px;" @click="updateAbsence()"><i class="fa fa-save"></i></button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Inertia } from '@inertiajs/inertia'
export default {
    props:['personnels', 'isActive', 'absence'],
    data(){
        return{
            Form:{
                nbr_absence: this.absence !=null ? this.absence.nbr_absence: null,
                mois:  this.absence !=null ? this.absence.mois: null,
                personnel_id:  this.absence !=null ? this.absence.personnel_id: null
            },
            is_active: false,
        }
    },
    methods:{
        getPersonnel(event){
            let id = event.target.value
            this.personnel = this.personnels.find(
                personnel => personnel.id == id
            )
        },
        addAbsence(){
            let url = ('/absence/create')
            let formData = new FormData()
            formData.append('nbr_absence', this.Form.nbr_absence)
            formData.append('mois', this.Form.mois)
            formData.append('personnel_id', this.Form.personnel_id)
            Inertia.post(url, formData)
            this.Form.nbr_absence = null,
            this.Form.mois = null,
            this.Form.personnal_id = null
        },
        updateAbsence(){
            let url = (`/absence/update/${this.absence.id}`)
            let formData = new FormData()
            formData.append('nbr_absence', this.Form.nbr_absence)
            formData.append('mois', this.Form.mois)
            formData.append('personnel_id', this.Form.personnel_id)
            Inertia.post(url, formData)
            this.Form.nbr_absence = null,
            this.Form.mois = null,
            this.Form.personnal_id = null

        },
        closeCard(){
            this.is_active = false
            this.$emit("closeCard", false)
        }
    },
    created(){
        this.is_active = this.isActive
        console.log(this.absence)
    },
}
</script>

<style scoped>
    .absence{
        display: none;
    }
    .absence.active{
        display: block ;
        opacity: 0;
        animation: opacityAnim 600ms ease forwards;
    }

    @keyframes opacityAnim {
        to{
            opacity: 1;
        }
    }
</style>
