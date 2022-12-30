<template>
    <div>
        <div class="container">
            <div class="header_links d-flex align-items-center py-3">
                <Link href="/paies" class="me-2">Liste</Link>/
                <Link href="/paie/create" class="me-2 ms-2">Ajouter</Link>/
            </div>
            <div class="_card mb-5">
                <div class="card mb-5">
                    <div class="card-header">
                        Editer fiche de paie
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <h6>Employé</h6>
                            <hr>
                            <div class="col-md-6">
                                <div class="row g-3 align-items-center">
                                    <div class="col-3 text-end mb-3">
                                        <label for="name" class="col-form-label">Employé:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <select class="form-select" id="departement" v-model="personnel.id" disabled>
                                            <option>--</option>
                                            <option  v-for="personnel in personnels" :key="personnel.id" :value="personnel.id" > {{personnel.name +' ' + personnel.first_name}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row g-3 align-items-center">
                                    <div class="col-3 text-end mb-3">
                                        <label for="month" class="col-form-label">Date d'embauche:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="date" id="month" class="form-control" aria-describedby="passwordHelpInline" v-model="personnel.hiring_date" disabled>
                                    </div>
                                </div>
                                <div class="row g-3 align-items-center">
                                    <div class="col-3 text-end mb-3">
                                        <label for="month" class="col-form-label">Salaire de base:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="number" id="month" class="form-control" aria-describedby="passwordHelpInline" v-model="personnel.base_salary" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row g-3 align-items-center">
                                    <div class="col-3 text-end mb-3">
                                        <label for="month" class="col-form-label">Mois:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="month" id="month" class="form-control" aria-describedby="passwordHelpInline" v-model="mois" @change="getNombreAbsence($event)">
                                    </div>
                                </div>
                                <div class="row g-3 align-items-center">
                                    <div class="col-3 text-end mb-3">
                                        <label for="month" class="col-form-label">Du:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="date" id="month" class="form-control" aria-describedby="passwordHelpInline" v-model="debut_periode">
                                    </div>
                                </div>
                                <div class="row g-3 align-items-center">
                                    <div class="col-3 text-end mb-3">
                                        <label for="month" class="col-form-label">Au:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="date" id="month" class="form-control" aria-describedby="passwordHelpInline" v-model="fin_periode">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h6>Absences</h6>
                        <div class="row">
                            <hr>
                            <div class="col-md-6">
                                <div class="row g-3 align-items-center">
                                    <div class="col-3 text-end mb-3">
                                        <label for="nbr_absence" class="col-form-label">Nombre d'absence</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="number" id="nbr_absence" class="form-control" aria-describedby="passwordHelpInline" v-model="nbr_absence">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" v-if="!isCadre">
                            <div class="col-md-6">
                                <h6>Indemnités imposables</h6>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Désignation</th>
                                            <th>Montant</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <AddIndemnity v-for="(indemnity, index) in indemnityForm" :key="index" :indemnity="indemnity" :imposable="true" :numero="index" @indemnity_data="getDataEmiting"/>
                                    </tbody>

                                    <button class="btn btn-primary mt-3" @click="generateAddIndemnity()"> Ajouter </button>

                                </table>
                            </div>
                            <div class="col-md-6">
                                <h6>Indemnités imposables</h6>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Désignation</th>
                                            <th>Montant</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <AddIndemnity v-for="(indemnity, index) in indemnityFormNonImposable" :key="index" :indemnity="indemnity" :imposable="false" :numero="index" @indemnity_data="getDataEmitingNonImposable"/>
                                    </tbody>

                                    <button class="btn btn-primary mt-3" @click="generateAddIndemnityNonImposable()">Ajouter</button>


                                </table>
                            </div>
                        </div>
                        <hr>
                        <h6>Simulation</h6>
                        <hr>
                            <div class="row simulation-btn" v-if="simulingActive">
                                <button class="btn btn-primary" @click="simuling"><i class="fa-solid fa-spinner me-3"></i> Simuler</button>
                            </div>
                        <hr>
                        <div class="row" v-if="Object.keys(this.personnel).length !== 0 && isSimuling">

                            <div class="card" style="box-shadow:none">
                                <div class="card-header text-center">
                                    BULLETIN DE PAIE
                                </div>
                                <div class="card-body d-flex">
                                    <div class="info-societe me-5">
                                        <h5>{{ personnel.workplace.establishment.societe.name }}</h5>

                                        <p>{{ personnel.workplace.establishment.societe.adresse }}</p>
                                        <p>{{ personnel.workplace.establishment.societe.tel }}</p>
                                        <p>{{ personnel.workplace.establishment.societe.email }}</p>
                                    </div>
                                    <div class="info-perso">
                                        <h5>{{ personnel.name }}</h5>
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <td>Période du: {{ mois }}</td>
                                                    <td>Du: {{ debut_periode }}</td>
                                                    <td>Au: {{ fin_periode }}</td>
                                                    <td>Paiment le: {{ fin_periode }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Matricule: {{ personnel.num_matricule }}</td>
                                                    <td>N° CNAPS: {{ personnel.num_cnaps }}</td>
                                                    <td>Date d'embauche: {{ personnel.hiring_date }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Categorie: {{ personnel.contrat.category }}</td>
                                                    <td>Emploi occupé: {{ personnel.workplace.name }}</td>
                                                    <td>Service: {{ personnel.workplace.establishment.name }}</td>
                                                    <td>CIN: {{ personnel.CIN }}</td>
                                                </tr>
                                            </tbody>
                                        </table>


                                    </div>
                                </div>
                            </div>

                            <table class="table table-bordered" v-if="isSimuling">
                                <template v-if="getConge()">
                                    <tbody>
                                        <tr>
                                            <td>Acquis: {{ personnel.nbr_conge }}</td>
                                            <td>Pris: {{ getConge().pris }}</td>
                                            <td>Reste à prendre: {{ getConge().reste }}</td>
                                            <td>
                                                Du: {{ getConge().date_depart1 }} <br>
                                                Au: {{ getConge().date_arrive1 }}
                                            </td>
                                            <td>
                                                Du: {{ getConge().date_depart2 }} <br>
                                                Au: {{ getConge().date_arrive2 }}
                                            </td>
                                            <td>
                                                Du: {{ getConge().date_depart3 }} <br>
                                                Au: {{ getConge().date_arrive3 }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </template>
                            </table>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">N°</th>
                                        <th scope="col">Designation</th>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">Base</th>
                                        <th scope="col">Taux part salarial</th>
                                        <th scope="col">Gain</th>
                                        <th scope="col">retenue part salariale</th>
                                        <th scope="col">Taux part patronal</th>
                                        <th scope="col">retenue part patronal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row" v-text="personnel.num_matricule"></th>
                                        <th >Salaire de base</th>
                                        <td>{{ personnel.nombre }}</td>
                                        <td>{{ formatNumber(personnel.base_salary) }}</td>
                                        <td></td>
                                        <td>{{ formatNumber(gain_base) }}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr v-for="indemnity in indemnityForm" :key="indemnity.numero">
                                        <td></td>
                                        <td>{{ indemnity.designation }}</td>
                                        <td></td>
                                        <td>{{ indemnity.montant }}</td>
                                        <td></td>
                                        <td>{{ indemnity.montant }}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr v-for="indemnity in indemnityFormNonImposable" :key="indemnity.numero">
                                        <td></td>
                                        <td>{{ indemnity.designation }}</td>
                                        <td></td>
                                        <td>{{ indemnity.montant }}</td>
                                        <td></td>
                                        <td>{{ indemnity.montant }}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr v-for="rubrique in getFilteredRubriques('brut')" :key="rubrique.id">
                                        <th scope="row">{{ rubrique.numero }}</th>
                                        <th>{{ rubrique.designation }}</th>
                                        <th v-if="rubrique.designation.toLowerCase() === 'Absence'.toLocaleLowerCase() ">{{ nbr_absence}}</th>
                                        <th v-else>{{ rubrique.nombre}}</th>
                                        <td>{{ formatNumber(rubrique.base) }}</td>
                                        <td>{{ rubrique.taux_part_salarial }}</td>
                                        <td>{{ calculGainBrut(rubrique) }}</td>
                                        <td v-if="rubrique.designation.toLowerCase() === 'Absence'.toLocaleLowerCase() ">{{formatNumber(rubrique.base* nbr_absence)}}</td>
                                        <td v-else>{{formatNumber(calculRetenuBrut(rubrique.isRetenue,rubrique.taux_part_salarial, rubrique.nombre,rubrique.base))}}</td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th colspan="5">TOTAL BRUT</th>
                                        <th colspan="1">{{ formatNumber(total_gain_brut) }}</th>
                                        <th colspan="2">{{ formatNumber(total_brute_salarial) }}</th>
                                        <th colspan="2"></th>

                                    </tr>
                                    <tr v-for="rubrique in getFilteredRubriques('cotisations')" :key="rubrique.id">
                                        <td>{{ rubrique.numero }}</td>
                                        <td>{{ rubrique.designation }}</td>
                                        <td></td>
                                        <td></td>
                                        <td>{{ rubrique.taux_part_salarial }}</td>
                                        <td>{{ calculGainBrut(rubrique) }}</td>
                                        <td>{{ formatNumber((rubrique.taux_part_salarial * this.gain_base)/100) }}</td>
                                        <td>{{ rubrique.taux_part_patronal }}</td>
                                        <td>{{ formatNumber((rubrique.taux_part_patronal * this.gain_base)/100) }}</td>

                                    </tr>
                                    <!-- TOTAL COTISATIONS -->
                                    <tr>
                                        <th colspan="6">TOTAL COTISATIONS</th>
                                        <th colspan="2">{{ formatNumber(total_cotisations_salarial) }}</th>
                                        <th colspan="2">{{ formatNumber(total_cotisations_patronal) }}</th>

                                    </tr>
                                    <tr v-for="rubrique in  getFilteredRubriques('autre')" :key="rubrique.id">
                                        <td>{{ rubrique.numero }}</td>
                                        <td>{{ rubrique.designation }}</td>
                                        <td>{{ rubrique.nombre }}</td>
                                        <td>{{ rubrique.base }}</td>
                                        <td>{{ rubrique.taux_part_salarial }}</td>
                                        <td>{{ rubrique.gain }}</td>
                                        <td></td>
                                        <td>{{ rubrique.taux_part_patronal }}</td>
                                        <td></td>
                                    </tr>
                                    <tr v-for="rubrique in  getFilteredRubriques('charge familiale')" :key="rubrique.id">
                                        <td>{{ rubrique.numero }}</td>
                                        <td>{{ rubrique.designation }}</td>
                                        <td>{{ personnel.number_children }}</td>
                                        <td>{{ rubrique.base }}</td>
                                        <td>{{ rubrique.taux_part_salarial }}</td>
                                        <td>{{ gain_enfant_charge }}</td>
                                        <td></td>
                                        <td>{{ rubrique.taux_part_patronal }}</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>8000</td>
                                        <td>Retenue IRSA</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>{{ valeur_irsa.toFixed(2) }}</td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th colspan="5">TOTAL</th>
                                        <th>{{ gain_total }}</th>
                                        <th colspan="2">{{ this.retenue_salarial_total }}</th>
                                        <th>{{ this.retenue_patronal_total }}</th>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="card mb-5" style="box-shadow:none">
                                    <p>Salaire brute: {{ (total_gain_brut - total_brute_salarial).toFixed(2) }}</p>
                                    <p>Salaire brute imposable: {{ (total_gain_brut - total_brute_salarial - valeur_irsa).toFixed(2) }}</p>
                                    <p>Net à payer: {{ (gain_total - retenue_salarial_total).toFixed(2) }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row save-btn">
                            <button class="btn btn-primary" @click="updateBulletin()"><i class="fa-solid fa-save me-3"></i> Enregistrer</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import MainLayout from '../../Layout/MainLayout.vue';
import AddIndemnity from '../../components/AddIndemnity.vue'
import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/inertia-vue3';
export default {
    layout: MainLayout,
    props: ['personnels', 'rubriques', 'irsas', 'bulletin'],
    components:{
        AddIndemnity,
        Link
    },

    data(){
        return{
            personnel:{},
            isSimuling: false,
            simulingActive :false,
            mois: this.bulletin.mois,
            nbr_absence: null,
            debut_periode:this.bulletin.debut_periode,
            fin_periode: this.bulletin.fin_periode != null ? this.bulletin.fin_periode: null,
            gain_base: 0,
            total_gain_brut:0,
            gain_total:0,
            retenue_salarial_total: 0,
            retenue_patronal_total: 0,
            base_brut_imposable: 0,
            total_brute_salarial:0,
            total_cotisations_patronal: 0,
            total_cotisations_salarial: 0,
            gain_enfant_charge: 0,
            valeur_irsa: 0,
            compteur_indemnity: 0,
            compteur_indemnity_non_imposable: 0,
            add_indemnity: [],
            add_indemnity_non_imposable: [],
            indemnityForm: [],
            indemnityFormNonImposable: [],
            conge: {},
            actualTotalIndemnity: 0,
            isCadre: false
        }
    },
    methods:{
        getNombreAbsence(event){
            let month = event.target.value
            this.personnel.absences.forEach(absence => {
                if(month === absence.mois){
                    this.nbr_absence = absence.nbr_absence
                }
            })
        },
        Calculing(){
            this.calculTotalBrut();
            this.calculTotalCotisations();
        },
        getFilteredRubriques(type){
            return this.rubriques.filter(
                rubrique => {
                    return rubrique.type.toLowerCase().includes(type.toLowerCase())
                }
            )
        },
        calculTotalCotisations(){
            let total_cotisations_patronal = 0
            let total_cotisations_salarial = 0

            this.rubriques.forEach(rubrique => {
                if(rubrique.type.toLowerCase() === "cotisations"){
                    total_cotisations_salarial =  total_cotisations_salarial + (rubrique.taux_part_salarial * this.gain_base)/100
                    total_cotisations_patronal =  total_cotisations_patronal + (rubrique.taux_part_patronal * this.gain_base)/100
                }
            });
            this.total_cotisations_salarial = total_cotisations_salarial
            console.log(total_cotisations_salarial)
            this.total_cotisations_patronal = total_cotisations_patronal
        },
        calculTotalBrut(){
            let total_gain_brut = 0
            let total_brute_salarial = 0
            this.gain_base = this.personnel.nombre * this.personnel.base_salary
            total_gain_brut = total_gain_brut + this.gain_base
            this.base_brut_imposable = total_gain_brut
            this.rubriques.forEach(rubrique => {
                if(rubrique.type.toLowerCase() === "brut".toLowerCase()){
                    total_gain_brut = parseFloat(total_gain_brut) + parseFloat(this.calculGainBrut(rubrique))
                   if(rubrique.isRetenue){
                        if(rubrique.taux_part_salarial === null){
                            if(rubrique.designation.toLowerCase() == "Absence".toLowerCase()){
                                total_brute_salarial= total_brute_salarial + this.nbr_absence* rubrique.base
                            }else{
                                total_brute_salarial = total_brute_salarial + rubrique.nombre * rubrique.base
                                if(rubrique.isImposable){
                                    this.base_brut_imposable = this.base_brut_imposable + rubrique.nombre * rubrique.base
                                }
                            }
                        }else{
                            if(rubrique.designation.toLowerCase() === "Absence".toLowerCase()){
                                total_brute_salarial = total_brute_salarial + (this.nbr_absence  * rubrique.base * rubrique.taux_part_salarial)/100
                            }else{
                                total_brute_salarial = total_brute_salarial + (rubrique.nombre  * rubrique.base * rubrique.taux_part_salarial)/100
                                if(rubrique.isImposable){
                                    this.base_brut_imposable = this.base_brut_imposable + (rubrique.nombre  * rubrique.base * rubrique.taux_part_salarial)/100
                                }
                            }
                        }
                   }else{
                        if(rubrique.taux_part_salarial === null){
                            if(rubrique.isImposable){
                                this.base_brut_imposable = this.base_brut_imposable + rubrique.nombre * rubrique.base
                            }
                        }else{
                            if(rubrique.isImposable){
                                this.base_brut_imposable = this.base_brut_imposable + (rubrique.nombre  * rubrique.base * rubrique.taux_part_salarial)/100
                            }
                        }

                   }
                }
            })

            this.indemnityForm.forEach(indemnity => {
                if(indemnity.montant != ''){
                    total_gain_brut = total_gain_brut + indemnity.montant
                }
            })

            this.indemnityFormNonImposable.forEach(indemnity => {
                if(indemnity.montant != ''){
                    total_gain_brut = total_gain_brut + indemnity.montant
                }
            })

            this.total_gain_brut = total_gain_brut
            this.total_brute_salarial = total_brute_salarial
        },
        formatNumber(number){
            const number_format = new Intl.NumberFormat('fr-FR', {
                minimumFractionDigits: 2
            });

            return number_format.format(number)
        },
        simuling(){
            this.isSimuling= true
            this.Calculing()
            this.calculIRSA()
            this.totalGain()
            this.totalRetenue()
            this.getCongePersonnel()
        },
        activeSimuling(){
            if(this.debut_periode !== null && this.fin_periode !==null && this.mois !== null ){
                this.simulingActive = true
            }
        },
        calculRetenuBrut(isRetenue,taux_part_salarial, nombre, base){
            if(isRetenue){
                if(nombre===null){
                    nombre=1
                }
                if(taux_part_salarial === null || taux_part_salarial === 0){
                    return (nombre * base).toFixed(2)
                }else{
                    return ((nombre * base * taux_part_salarial)/100).toFixed(2)
                }
            }else{
                return 0
            }
        },
        calculGainBrut(rubrique){
            if(!rubrique.isRetenue){
                if(rubrique.taux_part_salarial === null || rubrique.taux_part_salarial===0){
                    return (rubrique.nombre * rubrique.base).toFixed(2)
                }else{
                    return (( rubrique.nombre * rubrique.base * rubrique.taux_part_salarial)/100).toFixed(2)
                }
            }else{
                return 0
            }
        },
        totalGain(){
            this.getFilteredRubriques('charge familiale').forEach(rubrique => {
                this.gain_enfant_charge =  this.personnel.number_children * rubrique.base
            })
            this.gain_total = this.total_gain_brut + this.gain_enfant_charge
        },
        totalRetenue(){
            this.retenue_salarial_total = this.total_brute_salarial + this.total_cotisations_salarial + this.valeur_irsa
            this.retenue_patronal_total = this.total_cotisations_patronal
        },
        calculIRSA(){

            for (let i = 0; i < this.irsas.length; i++) {
                if(this.base_brut_imposable > this.irsas[i].base_min && this.base_brut_imposable <= this.irsas[i].base_max){
                    if(i===1){
                        this.valeur_irsa = (this.base_brut_imposable - this.irsas[i].base_min) * (this.irsas[i].taux/100)
                    }
                    if(i===2){
                        this.valeur_irsa = (this.irsas[i-1].base_max - this.irsas[i-1].base_min) * (this.irsas[i-1].taux/100) + (this.base_brut_imposable - this.irsas[i].base_min) * (this.irsas[i].taux/100)
                    }
                    if(i===3){
                        this.valeur_irsa = (this.irsas[i-2].base_max - this.irsas[i-2].base_min) * (this.irsas[i-2].taux/100) + (this.irsas[i-1].base_max - this.irsas[i-1].base_min) * (this.irsas[i-1].taux/100) + (this.base_brut_imposable - this.irsas[i].base_min) * (this.irsas[i].taux/100)
                    }
                }
                if(i===(this.irsas.length-1)){
                    if(this.base_brut_imposable > this.irsas[i].base_min){
                        this.valeur_irsa = (this.irsas[i-3].base_max - this.irsas[i-3].base_min)* (this.irsas[i-3].taux/100) + (this.irsas[i-2].base_max - this.irsas[i-2].base_min) * (this.irsas[i-2].taux/100) + (this.irsas[i-1].base_max - this.irsas[i-1].base_min) * (this.irsas[i-1].taux/100) + (this.base_brut_imposable - this.irsas[i].base_min) * (this.irsas[i].taux/100)
                    }
                }
            }
        },
        generateAddIndemnity(){
            this.add_indemnity.push(this.compteur_indemnity++)
            this.indemnityForm.push({
                numero : this.compteur_indemnity++,
                designation: '',
                montant: null,
                isImposable: true
            })


        },
        generateAddIndemnityNonImposable(){
            this.add_indemnity_non_imposable.push(this.compteur_indemnity_non_imposable++)
            this.indemnityFormNonImposable.push({
                numero : this.compteur_indemnity++,
                designation: '',
                montant: null,
                isImposable: false
            })
        },
        getDataEmitingNonImposable(payload){
            let index= payload.numero
            this.indemnityFormNonImposable[index].designation = payload.designation
            this.indemnityFormNonImposable[index].montant = payload.montant
            console.log(this.indemnityFormNonImposable)
        },
        getDataEmiting(payload){
            let index= payload.numero
            this.indemnityForm[index].designation = payload.designation
            this.indemnityForm[index].montant = payload.montant
        },
        updateBulletin(){

            let formData = new FormData()
            formData.append("debut_periode", this.debut_periode)
            formData.append("fin_periode", this.fin_periode)
            formData.append("date_payement", this.fin_periode)
            formData.append("mois", this.mois)
            formData.append("total_gain_brut", this.total_gain_brut)
            formData.append("retenue_irsa", this.valeur_irsa)
            formData.append("total_brut_salarial", this.total_brute_salarial)
            formData.append("total_cotisations_salarial", this.total_cotisations_salarial)
            formData.append("total_cotisations_patronal", this.total_cotisations_patronal)
            formData.append("gain_enfant_charge", this.gain_enfant_charge)
            formData.append("valeur_irsa", this.valeur_irsa)
            formData.append("gain_total", this.gain_total)
            formData.append("retenue_salarial_total", this.retenue_salarial_total)
            formData.append("retenue_patronal_total", this.retenue_patronal_total)
            formData.append("personnel_id", this.personnel.id)
            formData.append("id_payement", 1)
            formData.append("indemnityForm",  JSON.stringify(this.indemnityForm))
            formData.append("formDataIndemnityNonImposabe", JSON.stringify(this.indemnityFormNonImposable))

            let url = `/paie/update/${this.bulletin.id}`
            Inertia.post(url, formData)

        },
        getCongePersonnel(){
            let year = new Date(this.mois)
            this.conge = this.personnel.conges.find(
                conge => conge.year == year.getFullYear()
            )
        },
        getConge(){
            let yeraActuel = new Date().getFullYear()
            return this.personnel.conges.find(
                conge => {
                    let date = new Date(conge.date_depart1)

                    return date.getFullYear() === yeraActuel
                }
            )
        }
    },
    created(){
        console.log(this.bulletin)
       this.personnel = this.bulletin.personnel
       this.activeSimuling()
       this.personnel.absences.forEach(absence => {
            console.log(this.bulletin.mois)
            if(this.bulletin.mois === absence.mois){
                this.nbr_absence = absence.nbr_absence
            }
        });

        this.bulletin.indemnities.forEach(indemnity => {
            this.actualTotalIndemnity = this.actualTotalIndemnity + indemnity.montant
        });

        if(Object.keys(this.bulletin.indemnities).length != 0){
            this.bulletin.indemnities.forEach(indemnity => {
                if(indemnity.isImposable){
                    this.add_indemnity.push(this.compteur_indemnity++)
                    this.indemnityForm.push({
                        id: indemnity.id,
                        numero : this.compteur_indemnity++,
                        designation: indemnity.designation,
                        montant: indemnity.montant,
                        isImposable: true
                    })
                }else{
                    this.add_indemnity_non_imposable.push(this.compteur_indemnity_non_imposable++)
                    this.indemnityFormNonImposable.push({
                        id: indemnity.id,
                        numero : this.compteur_indemnity++,
                        designation: indemnity.designation,
                        montant: indemnity.montant,
                        isImposable: false
                    })
                }
            })
        }
        if(this.personnel.statut.name.toLowerCase() === "cadre".toLowerCase()){
            this.isCadre = true
        }else{
            this.isCadre = false
        }

    },
    updated(){
        this.activeSimuling()
    }
}
</script>

<style>

</style>
