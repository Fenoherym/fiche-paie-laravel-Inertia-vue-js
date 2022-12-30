<template>
    <div>
        <div class="container">
            <div class="header_links d-flex align-items-center py-3">
                <Link href="/personnels" class="me-2">Liste</Link>/
                <Link href="/personnel/create" class="me-2 ms-2">Ajouter</Link>/
            </div>
            <div class="_card mb-5">
                <div class="card mb-5">
                    <div class="card-header">
                        Modifié un employé
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row g-3 align-items-center">
                                    <div class="col-3 text-end mb-3">
                                        <label for="name" class="col-form-label">Nom:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" id="name" class="form-control" :class="{ 'is-invalid': errors.name != null }" aria-describedby="passwordHelpInline" v-model="form.name">
                                        <div class="invalid-feedback" v-if="errors.name != null">
                                            {{ errors.name }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-items-center mb-3">
                                    <div class="col-3 text-end">
                                        <label for="first_name" class="col-form-label">Prenom:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" id="first_name" class="form-control" :class="{ 'is-invalid': errors.first_name != null }" aria-describedby="passwordHelpInline" v-model="form.first_name" >
                                        <div class="invalid-feedback" v-if="errors.first_name != null">
                                            {{ errors.first_name }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-items-center mb-3">
                                    <div class="col-3 text-end">
                                        <label for="num_matricule" class="col-form-label">N° Matricule:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" id="num_matricule" class="form-control" :class="{ 'is-invalid': errors.num_matricule != null }" aria-describedby="passwordHelpInline" v-model="form.num_matricule">
                                        <div class="invalid-feedback" v-if="errors.num_matricule != null">
                                            {{ errors.num_matricule }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-items-center mb-3">
                                    <div class="col-3 text-end">
                                        <label for="sexe" class="col-form-label">Sexe:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="form-check  form-check-inline">
                                            <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="Homme" v-model="form.sexe">
                                            <label class="form-check-label" for="exampleRadios1">
                                                Homme
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="Femme" v-model="form.sexe">
                                            <label class="form-check-label" for="exampleRadios2">
                                                    Femme
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-items-center mb-3">
                                    <div class="col-3 text-end">
                                        <label for="enfants" class="col-form-label">Nbr Enfants:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="number" min="0" id="enfants" class="form-control"  aria-describedby="passwordHelpInline" v-model="form.number_children">
                                    </div>
                                </div>
                                <div class="row g-3 align-items-center mb-3">
                                    <div class="col-3 text-end">
                                        <label for="enfants" class="col-form-label">CIN:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" id="enfants" class="form-control" :class="{ 'is-invalid': errors.CIN !=null }" aria-describedby="passwordHelpInline" v-model="form.CIN">
                                        <div class="invalid-feedback" v-if="errors.CIN !=null">
                                            {{ errors.CIN }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-items-center mb-3">
                                    <div class="col-3 text-end">
                                        <label for="enfants" class="col-form-label">N° CNAPS:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" id="enfants" class="form-control" aria-describedby="passwordHelpInline" v-model="form.num_cnaps">
                                    </div>
                                </div>
                                <div class="row g-3 align-items-center mb-3">
                                    <div class="col-3 text-end">
                                        <label for="enfants" class="col-form-label">Type de rénumeration</label>
                                    </div>
                                    <div class="col-md-9">
                                        <select class="form-select" :class="{ 'is-invalid': errors.type_renumeration != null }" aria-label="Default select example"  @change="getTypeRenumeration($event)" v-model="form.type_renumeration">
                                            <option value="">--choisir le type de rénumeration</option>
                                            <option  value="Horaire">Horaire</option>
                                            <option  value="Journalier">Journalier</option>
                                            <option  value="Mensuel">Mensuel</option>
                                        </select>
                                        <div class="invalid-feedback" v-if="errors.type_renumeration != null">
                                            {{ errors.type_renumeration }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-items-center mb-3">
                                    <div class="col-3 text-end">
                                        <label for="enfants" class="col-form-label">Nombre:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="number"  id="enfants" class="form-control" :class="{ 'is-invalid': errors.nombre != null }" aria-describedby="passwordHelpInline" v-model="form.nombre" :disabled="isDisabled">
                                        <div class="invalid-feedback" v-if="errors.nombre != null">
                                            {{ errors.nombre }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-items-center mb-3">
                                    <div class="col-3 text-end">
                                        <label for="enfants" class="col-form-label">Salaire de base:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="number"  id="enfants" class="form-control" :class="{ 'is-invalid': errors.base_salary != null }" aria-describedby="passwordHelpInline" v-model="form.base_salary">
                                        <div class="invalid-feedback" v-if="errors.base_salary != null">
                                            {{ errors.base_salary }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row g-3 align-items-center">
                                    <div class="col-3 text-end mb-3">
                                        <label for="address" class="col-form-label">Adresse:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" id="address" class="form-control" :class="{ 'is-invalid': errors.address != null }" aria-describedby="passwordHelpInline" v-model="form.address">
                                        <div class="invalid-feedback" v-if="errors.address != null">
                                            {{ errors.address }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-items-center mb-3">
                                    <div class="col-3 text-end">
                                        <label for="tel" class="col-form-label">Telephone:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="tel" id="tel" class="form-control" aria-describedby="passwordHelpInline" v-model="form.telephone">
                                    </div>
                                </div>
                                <div class="row g-3 align-items-center mb-3">
                                    <div class="col-3 text-end">
                                        <label for="email" class="col-form-label">Email:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" id="email" class="form-control" aria-describedby="passwordHelpInline" v-model="form.email">
                                    </div>
                                </div>
                                <div class="row g-3 align-items-center mb-3">
                                    <div class="col-3 text-end">
                                        <label for="birthday" class="col-form-label">Date de naissance:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="date" id="birthday" class="form-control" :class="{ 'is-invalid': errors.birthday != null }"  aria-describedby="passwordHelpInline" v-model="form.birthday">
                                        <div class="invalid-feedback" v-if="errors.birthday != null">
                                            {{ errors.birthday }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-items-center mb-3">
                                    <div class="col-3 text-end">
                                        <label for="hiring_date" class="col-form-label">Date de d'embauche:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="date" id="hiring_date" class="form-control" :class="{ 'is-invalid': errors.hiring_date != null }" aria-describedby="passwordHelpInline" v-model="form.hiring_date">
                                        <div class="invalid-feedback" v-if="errors.hiring_date != null">
                                            {{ errors.hiring_date }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-items-center mb-3">
                                    <div class="col-3 text-end">
                                        <label for="date_of_departure" class="col-form-label">Date de départ:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="date" id="date_of_departure" class="form-control" aria-describedby="passwordHelpInline" v-model="form.date_of_departure">
                                    </div>
                                </div>
                                <div class="row g-3 align-items-center mb-3">
                                    <div class="col-3 text-end">
                                        <label for="nbr_conge" class="col-form-label">Nombre de jours de congés par</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="number"  id="nbr_conge" class="form-control" :class="{ 'is-invalid': errors.nbr_conge != null }" aria-describedby="passwordHelpInline" v-model="form.nbr_conge">
                                        <div class="invalid-feedback" v-if="errors.nbr_conge != null">
                                            {{ errors.nbr_conge }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-items-center mb-3">
                                    <div class="col-3 text-end">
                                        <label for="date_of_departure" class="col-form-label">Photo:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="file" id="date_of_departure" class="form-control" aria-describedby="passwordHelpInline">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h6>Poste</h6>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row g-3 align-items-center">
                                    <div class="col-3 text-end mb-3">
                                        <label for="departement" class="col-form-label">Fonction:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <select class="form-select" :class="{ 'is-invalid': errors.workplace_id != null }" id="departement" v-model="form.workplace_id">
                                            <option  v-for="workplace in workplaces" :key="workplace.id" :value="workplace.id"> {{workplace.name}}</option>
                                        </select>
                                        <div class="invalid-feedback" v-if="errors.workplace_id != null">
                                            {{ errors.workplace_id }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row g-3 align-items-center">
                                    <div class="col-3 text-end mb-3">
                                        <label for="name" class="col-form-label">Type de contrat:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <select class="form-select" :class="{ 'is-invalid': errors.contrat_id != null }" aria-label="Default select example" v-model="form.contrat_id">
                                            <option  v-for="contrat in contrats" :key="contrat.id" :value="contrat.id" > {{contrat.name}}</option>
                                        </select>
                                        <div class="invalid-feedback" v-if="errors.contrat_id != null">
                                            {{ errors.contrat_id }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-items-center">
                                    <div class="col-3 text-end mb-3">
                                        <label for="name" class="col-form-label">Status:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <select class="form-select" aria-label="Default select example" v-model="form.statut_id" :class="{ 'is-invalid': errors.statut_id != null }">
                                            <option  v-for="statut in statuts" :key="statut.id" :value="statut.id"> {{statut.name}}</option>
                                        </select>
                                        <div class="invalid-feedback" v-if="errors.workplace_id != null">
                                            {{ errors.statut_id }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row save-btn">

                            <button class="btn btn-primary" @click="updatePersonnel(personnel.id)">Enregistrer</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import MainLayout from '../../Layout/MainLayout.vue';
import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/inertia-vue3';
export default {
    layout: MainLayout,
    components:{
        Link,
    },
    props: ['personnel','contrats', 'statuts', 'establishments', 'workplaces', 'errors'],
    data(){
        return{
            form:{
                name: this.personnel.name,
                first_name: this.personnel.first_name,
                num_matricule:  this.personnel.num_matricule,
                sexe: "",
                birthday: this.personnel.birthday,
                telephone: this.personnel.telephone,
                number_children: this.personnel.number_children,
                address: this.personnel.address,
                base_salary: this.personnel.base_salary,
                CIN: this.personnel.CIN,
                email: this.personnel.email,
                num_cnaps: this.personnel.num_cnaps,
                hiring_date: this.personnel.hiring_date,
                date_of_departure: this.personnel.date_of_departure,
                contrat_id: this.personnel.contrat_id,
                statut_id: this.personnel.statut_id,
                workplace_id: this.personnel.statut_id,
                nombre: this.personnel.nombre,
                type_renumeration: this.personnel.type_renumeration,
                nbr_conge: this.personnel.nbr_conge
            },
        }
    },
    methods:{
        updatePersonnel(id){
            let formData = new FormData();
            formData.append('name', this.form.name);
            formData.append('first_name', this.form.first_name);
            formData.append('num_matricule', this.form.num_matricule);
            formData.append('sexe', this.form.sexe);
            formData.append('birthday', this.form.birthday);
            formData.append('telephone', this.form.telephone);
            formData.append('email', this.form.email);
            formData.append('number_children', this.form.number_children);
            formData.append('address', this.form.address);
            formData.append('base_salary', this.form.base_salary);
            formData.append('CIN', this.form.CIN);
            formData.append('num_cnaps', this.form.num_cnaps);
            formData.append('hiring_date', this.form.hiring_date);
            formData.append('date_of_departure', this.form.date_of_departure);
            formData.append('contrat_id', this.form.contrat_id);
            formData.append('statut_id', this.form.statut_id);
            formData.append('workplace_id', this.form.workplace_id);
            formData.append('type_renumeration' ,this.form.type_renumeration)
            formData.append('nombre' ,this.form.nombre)
            formData.append('nbr_conge', this.form.nbr_conge)
            Inertia.post(`/personnel/update/${id}`, formData);
        }
    },
    created(){
        this.workplaces.forEach(workplace => {
            if(this.personnel.workplace_id ===  workplace.id){
                this.form.workplace_id =  workplace.id
            }
        })
        this.statuts.forEach(statut => {
            if(this.personnel.statut_id === statut.id){
                this.form.statut_id = statut.id
            }
        })

        if(this.personnel.sexe == 1){
            this.form.sexe ="Homme"
        }else{
            this.form.sexe ="Femme"
        }

        if(this.personnel.number_children == null){
            this.form.number_children = ''
        }

    }
}
</script>

<style>



</style>
