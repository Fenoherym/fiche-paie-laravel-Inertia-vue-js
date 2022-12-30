<template>
    <div>
        <div class="container">

            <div class="row">
                <div class="row mb-3">
                    <div class="col-md-3">
                        <div class="_card">
                            <div class="card p-3 py-4 text-center dash-card employe">
                                <div class="d-flex justify-content-between">
                                    <p style="color:#f87979;">EMPLOYES: {{ personnels.length }}</p>
                                    <p style="color:#f87979;"><i class="fa-solid fa-users"></i></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="_card">
                            <div class="card p-3 py-4 text-center dash-card">
                                <div class="d-flex justify-content-between">
                                    <p style="color:#8f3c8f;">SERVICES: {{ services.length }}</p>
                                    <p style="color:#8f3c8f;"><i class="fa-solid fa-users"></i></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="_card">
                            <div class="card p-3 py-4 text-center dash-card">
                                <div class="d-flex justify-content-between">
                                    <p class="text-success">ABSENTS: {{ countAbsenceThisMonth }}</p>
                                    <p class="text-success"><i class="fa-brands fa-servicestack"></i></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="_card ">
                            <div class="card  p-2 py-4 text-center dash-card">
                                <div class="d-flex justify-content-between">
                                    <p style="color:#8f3c8f;">CONGES CE MOIS: {{ getCongeMonthCount() }}</p>
                                    <p style="color:#8f3c8f;"><i class="fa-solid fa-sun"></i></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="_card">
                        <div class="card p-3">
                            <bar-chart :labels="service" :data="serviceCount" title="Nombre d'employés pour chaque services"></bar-chart>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="_card">
                        <div class="card p-3">
                            <line-chart :labels="months" :data="absencePerMonthCount" title="Nombre d'absences"></line-chart>
                        </div>
                    </div>
                </div>
                <!-- <div class="col-md-6">
                    <div class="_card">
                        <div class="card p-3">
                            <pie-chart></pie-chart>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
</template>

<script>

import MainLayout from '../Layout/MainLayout.vue';
import BarChart from '../components/BarChart.vue';
import LineChart from '../components/LineChart.vue';
import PieChart from '../components/PieChart.vue';

export default {
    layout: MainLayout,
    components:{
        BarChart,
        LineChart,
        PieChart
    },
    props:['bulletins', 'personnels' , 'absences', 'services', 'conges'],
    data(){
        return{
            bulletinPerMonth: [],
            bulletinPerMonthCount: [],
            absencePerMonthCount: [],
            countAbsenceThisMonth: 0,
            service: [],
            serviceCount: [],
            months:['Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Decembre']
        }
    },
    created(){
        this.services.forEach(service => {
            let count = this.personnels.filter(
                personnel => {
                    return personnel.workplace.establishment.name === service.name
                }
            ).length

            this.service.push(service.name)
            this.serviceCount.push(count)
        });
        let dateActuel = new Date();
        let count = 0
        for (let index = 1; index <= 12; index++) {
            count = this.absences.filter(
                absence => {
                    let date = new Date(absence.mois)
                    return  date.getMonth() === index && date.getFullYear() === dateActuel.getFullYear()
                }
            ).length
            this.countAbsenceThisMonth =  this.absences.filter(
                absence => {
                    let date = new Date(absence.mois)
                    return  date.getMonth() === dateActuel.getMonth()
                }
            ).length

            this.absencePerMonthCount.push(count)

        }
    },
    methods:{
        getCongeMonthCount(){
            let month = new Date().getMonth()
           return this.conges.filter(
                conge => {
                    let date = new Date(conge.date_depart1)
                    let date2 = new Date(conge.date_depart2)
                    let date3 = new Date(conge.date_depart3)
                    return date.getMonth() === month ||
                    date2.getMonth() || date3.getMonth()
                }
            ).length
        }
    }


}
</script>

<style scoped>
    .dash-card p{
        padding: 0;
        margin: 0;
        font-size: 1.1rem;
        font-weight: 600;
    }
    .dash-card i{
        font-size: 1.6rem;
    }
</style>
