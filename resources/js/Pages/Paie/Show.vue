<template>
    <div class="body">
        <div class="container col-md-8">
            <div id="content" class="_card mt-5 mb-3">
                <h3 class="text-center">Bulletin de paie</h3>
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td rowspan="4" class="col-5">
                                <p>{{ bulletin.personnel.workplace.establishment.societe.name }}</p>
                                <p>{{ bulletin.personnel.workplace.establishment.societe.adresse }}</p>
                                <p>{{ bulletin.personnel.workplace.establishment.societe.NIF }}</p>
                                <p>{{ bulletin.personnel.workplace.establishment.societe.STAT }}</p>
                            </td>
                            <td rowspan="1">NOM: {{ bulletin.personnel.name }}  {{ bulletin.personnel.first_name }}</td>
                            <td>Période du: {{ bulletin.mois }}</td>
                            <td>Du: {{  bulletin.debut_periode }}</td>
                            <td>Au: {{  bulletin.fin_periode }}</td>
                            <td>Paiment le: {{  bulletin.fin_periode }}</td>
                        </tr>
                        <tr>
                            <td>Matricule: {{ bulletin.personnel.num_matricule }}</td>
                            <td>N° CNAPS: {{ bulletin.personnel.num_cnaps }}</td>
                            <td>Date d'embauche: {{ bulletin.personnel.hiring_date }}</td>
                            <td  rowspan="1">TEL: {{ bulletin.personnel.telephone }}</td>
                            <td  rowspan="1">EMAIL: {{ bulletin.personnel.email }}</td>
                        </tr>
                        <tr>
                            <td colspan="3">Nb d'enfant à charge: {{ bulletin.personnel.number_children }}</td>
                            <td colspan="2">Statut: {{ bulletin.personnel.statut.name }}</td>
                        </tr>
                    </tbody>
                </table>
                <table class="table table-bordered" v-if="getConge()">
                    <tbody>
                        <tr>
                            <td>Acquis: {{ bulletin.personnel.nbr_conge }}</td>
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
                </table>
                <table class="table table-bordered mt-5">
                    <thead>
                        <tr>
                            <th scope="col">N°</th>
                            <th scope="col">Designation</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Base</th>
                            <th scope="col">Taux salarial</th>
                            <th scope="col">Gain </th>
                            <th scope="col">Retenue salarial </th>
                            <th scope="col">Taux patronal</th>
                            <th scope="col">Retenue patronal </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td>Salaire de base</td>
                            <td>{{ bulletin.personnel.nombre }}</td>
                            <td>{{ bulletin.personnel.base_salary }}</td>
                            <td></td>
                            <td>{{ bulletin.personnel.base_salary*bulletin.personnel.nombre }}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Absence</td>
                            <td>{{ nbr_absence }}</td>
                            <td>{{ base_absence }}</td>
                            <td></td>
                            <td></td>
                            <td>{{ formatNumber(nbr_absence*base_absence) }}</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <template v-for="rubrique in getFilteredRubriques('brut')" :key="rubrique.id">
                            <tr v-if="rubrique.designation.toLowerCase() !== 'absence'.toLowerCase()">
                                <td>{{ rubrique.numero }}</td>
                                <td>{{ rubrique.designation }}</td>
                                <td>{{ rubrique.nombre }}</td>
                                <td>{{ formatNumber(rubrique.base) }}</td>
                                <td>{{ rubrique.taux_part_salarial }}%</td>
                                <td>{{ calculGainBrut(rubrique) }}</td>
                                <td></td>
                                <td>{{ rubrique.taux_part_patronal }}%</td>
                                <td>{{ formatNumber((rubrique.taux_part_patronal * bulletin.personnel.base_salary)/100)
                                }}</td>
                            </tr>
                        </template>
                        <tr v-for="indemnity in bulletin.indemnities" :key="indemnity.id">
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
                        <tr>
                            <th colspan="5">TOTAL BRUT</th>
                            <th colspan="1">{{ bulletin.total_gain_brut }}</th>
                            <th colspan="2">{{ total_retenue_brut }}</th>
                        </tr>
                        <tr v-for="rubrique in getFilteredRubriques('cotisations')" :key="rubrique.id">
                            <td>{{ rubrique.numero }}</td>
                            <td>{{ rubrique.designation }}</td>
                            <td></td>
                            <td>{{ formatNumber(bulletin.personnel.base_salary) }}</td>
                            <td>{{ rubrique.taux_part_salarial }}%</td>
                            <td></td>
                            <td>{{ formatNumber((rubrique.taux_part_salarial * bulletin.personnel.base_salary)/100)
                            }}</td>
                            <td>{{ rubrique.taux_part_patronal }}%</td>
                            <td>{{ formatNumber((rubrique.taux_part_patronal * bulletin.personnel.base_salary)/100)
                            }}</td>
                        </tr>
                        <tr>
                            <th colspan="6">Total Cotisations</th>
                            <th colspan="2">{{ bulletin.total_cotisations_salarial }}</th>
                            <th colspan="2">{{ bulletin.total_cotisations_patronal }}</th>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Enfant à charge</td>
                            <td>{{ bulletin.personnel.number_children }}</td>
                            <td>{{ base_enfant_charge }}</td>
                            <td></td>
                            <td>{{ bulletin.gain_enfant_charge }}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Retenue IRSA</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>{{ bulletin.valeur_irsa }}</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <th rowspan="2" colspan="5">TOTAL</th>
                            <th rowspan="2" colspan="1" class="py-2">{{bulletin.gain_total }}</th>
                            <th rowspan="2" colspan="2" class="py-2">{{bulletin.retenue_salarial_total }}</th>
                            <th rowspan="2" colspan="1" class="py-2">{{bulletin.retenue_patronal_total }}</th>
                        </tr>
                    </tbody>
                </table>
                <div class="card p-3">
                    <p>Salaire brute: {{ bulletin.total_gain_brut - bulletin.total_brut_salarial }} Ariary</p>
                    <p>Salaire brute imposable: {{ bulletin.gain_total - bulletin.total_brut_salarial - bulletin.valeur_irsa }} Ariary</p>
                    <p>Net à payer: {{ bulletin.gain_total - bulletin.retenue_salarial_total }} Ariary</p>
                </div>
            </div>

            <button class="btn btn-primary mb-3" id="print-btn" @click="telechargerPdf">telecharger en pdf</button>
        </div>
    </div>
</template>

<script>


export default {
    props: ["bulletin"],
    data() {
        return {
            nbr_absence: 0,
            base_absence: 0,
            base_enfant_charge: 0,
            total_retenue_brut:0
        }
    },
    methods: {
        getFilteredRubriques(type) {
            return this.bulletin.rubriques.filter(
                rubrique => {
                    return rubrique.type.toLowerCase().includes(type.toLowerCase())
                }
            )
        },
        formatNumber(number) {
            const number_format = new Intl.NumberFormat('fr-FR', {
                minimumFractionDigits: 2
            });

            return number_format.format(number)
        },
        calculGainBrut(rubrique){
            if(!rubrique.isRetenue){
                if(rubrique.taux_part_salarial === null){
                    return (rubrique.nombre * rubrique.base).toFixed(2)
                }else{
                    return (( rubrique.nombre * rubrique.base * rubrique.taux_part_salarial)/100).toFixed(2)
                }
            }else{
                return 0
            }
        },
        totalRetenueBrut(){
            this.total_retenue_brut = this.bulletin.total_brut_salarial
        },
        telechargerPdf() {
            document.querySelector('.body').style.overflowY = "hidden"
            document.querySelector('#print-btn').style.display = "none"
            window.print()
            document.querySelector('#print-btn').style.display = "block"
            document.querySelector('.body').style.overflowY = "auto"
        },
        getConge(){
            let yeraActuel = new Date().getFullYear()
            return this.bulletin.personnel.conges.find(
                conge => {
                    let date = new Date(conge.date_depart1)

                    return date.getFullYear() === yeraActuel
                }
            )
        }
    },
    created() {
        this.bulletin.personnel.absences.forEach(absence => {
            if (absence.mois === this.bulletin.mois) {
                this.nbr_absence = absence.nbr_absence
            }
        })

        this.bulletin.rubriques.forEach(rubrique => {
            if (rubrique.designation.toLowerCase() === 'absence'.toLowerCase()) {
                this.base_absence = rubrique.base
            }
            if (rubrique.type.toLowerCase() === 'charge familiale') {
                this.base_enfant_charge = rubrique.base
            }
        })

        this.totalRetenueBrut()
        console.log(this.getConge())

    },
}
</script>

<style scoped>
.body {
    padding-top: 50px;
    font-size: 14px;
    height: 100vh;
    padding: 0;
    margin: 0;
    font-family: 'poppins', sans-serif;
    font-size: 0.88rem;
    background: var(--color-background);
    overflow-x: hidden;
}

._card {
    background: #fff;
}

._card .card {
    box-shadow: none;
}

h3 {
    color: var(--color-dark);
    border: solid 1px var(--color-dark);
}
</style>
