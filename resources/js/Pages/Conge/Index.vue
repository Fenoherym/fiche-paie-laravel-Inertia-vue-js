<template>
    <div>
        <div class="container">
            <div class="mb-3 d-flex justify-content-start" v-if="isAdmin">
                <button class="btn btn-success me-2" @click="activeCalendar"><i class="fa fa-calendar"></i> Calendrier</button>
                <button class="notification btn btn-success me-2" @click="listCongeActive"><i class="fa fa-list"></i> Listes de conges <span>{{ countConge }}</span></button>
                <button class="notification btn btn-success me-2" @click="listAskActive"><i class="fa fa-list"></i> Listes des demandes  <span>{{ countAsk }}</span></button>
                <button class="btn btn-success me-2" @click="createCongeActive"><i class="fa fa-plus"></i> Ajout d'un conge</button>
            </div>
            <div class="row mb-3" v-if="!isAdmin">
                <div class="col-md-3">
                    <Link class="btn btn-success" href="/conges/employe/ask"><i class="fa fa-plus"></i> Demander un congé</Link>
                </div>
                <div class="col-md-3">
                    <IndexAsk :conges="getEmployeConge()"></IndexAsk>
                </div>
            </div>
            <create :personnels="personnels" v-if="createConge" :errors="errors"></create>
            <event-calendar :conges="getFilteredConges()" v-if="calendarActive && isAdmin"></event-calendar>
            <event-calendar :conges="getEmployeConge()" v-if="!isAdmin"></event-calendar>
            <div class="row" v-if="isAdmin">
                <div class="col-md-12">
                    <list-ask :conges="getAskConges()" v-if="listAsk"></list-ask>
                    <!-- <input type="text" class="form-control mt-3 mb-2" placeholder="recherche" v-model="q"> -->
                    <liste-conge :conges="getFilteredConges()" v-if="listConge"></liste-conge>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import dateFormat from "dateformat"
import MainLayout from '../../Layout/MainLayout.vue';
import { Link } from '@inertiajs/inertia-vue3';
import Pagination from '../../components/Pagination.vue';
import { usePage } from '@inertiajs/inertia-vue3';
import ListAsk from './ListAsk.vue'
import ListeConge from './ListeConge.vue'
import EventCalendar from './EventCalendar.vue'
import Create from './Create.vue'
import IndexAsk from './Employe/IndexAsk.vue'

export default {
    layout: MainLayout,
    components: {
        Link,
        Pagination,
        ListAsk,
        ListeConge,
        EventCalendar,
        Create,
        IndexAsk
    },
    props: ['conges', 'personnels', 'errors'],
    data(){
        return{
            personnel: {},
            form:{
                personnel_id: '',
                nbr_conge: '',
                year: '',
                pris: '',
                date_depart: '',
                date_arrive:'',
                reste:''
            },
            addCardActive: false,
            page_size: 5,
            page_number: 1,
            totalItems: this.conges.length,
            q: '',
            btnDisabled: true,
            calendarActive: true,
            listConge: false,
            listAsk: false,
            createConge : false,
            countConge: 0,
            countAsk: 0

        }
    },
    methods:{
        getPersonnel(id){
            this.addCardActive = false
            if(!this.addCardActive){
                this.personnel = this.personnels.find(
                    personnel => personnel.id === id

                )

                this.form.personnel_id = this.personnel.id
                this.form.nbr_conge = this.personnel.nbr_conge
                this.addCardActive = true
            }
        },
        getEmployeConge(){
            return this.conges.filter(
                conge => {
                    return conge.personnel.email === this.user.email
                }
            )
        },
        getAskConges(){
            return this.conges.filter(
                conge => {
                    return conge.congestatut.statut.toLowerCase() === "en attente"
                }
            )
        },
        getFilteredConges(){
            return this.conges.filter(
                conge => {
                    return (conge.personnel.name.toLowerCase().includes(this.q.toLowerCase()) ||
                    conge.personnel.first_name.toLowerCase().includes(this.q.toLowerCase())) && conge.congestatut.statut.toLowerCase() === "accordé"
                }
            )
        },
        paginate(page_size, page_number){
            return this.getAbsences().slice((page_number - 1) * page_size, page_number * page_size);
        },
        changePage(page){
            this.page_number = page
        },
        getDay(event){

            let reste_a_prendre = this.form.nbr_conge - this.getPris() -this.form.pris
            if(reste_a_prendre < 0){
                alert("Vous avez dépasser le nombre de jours de congés max pour cette personne")
                this.form.date_depart = ''
                this.btnDisabled = true
            }else{
                let date =  new Date(event.target.value)
                let day = date.setDate(date.getDate() + this.form.pris)
                this.form.date_arrive = dateFormat(new Date(day), "yyyy-mm-dd")
                this.btnDisabled = false
            }

        },
        getPris(){
            let pris = 0
            this.personnel.conges.forEach(conge => {
                pris = pris + conge.pris
            })
            alert(pris)
            return pris
        },
        listCongeActive(){
            this.listConge = true,
            this.calendarActive = false
            this.listAsk = false
            this.createConge = false
        },
        listAskActive(){
            this.listConge = false,
            this.calendarActive = false
            this.listAsk = true
            this.createConge = false
        },
        activeCalendar(){
            this.listConge = false,
            this.calendarActive = true
            this.listAsk = false
            this.createConge = false
        },
        createCongeActive(){
            this.listConge = false,
            this.calendarActive = false
            this.listAsk = false
            this.createConge = true
        }
    },
    created(){
        this.user = usePage().props.value.auth.user
        this.isAdmin = this.user.role.name.toLowerCase() === 'admin'.toLowerCase();
        this.countConge = this.getFilteredConges().length
        this.countAsk = this.getAskConges().length
    },
}
</script>

<style scoped>
h4 {
    color: var(--color-dark);
}

.img-user{
    display: flex;
    justify-content: center;
    border: 3px solid var(--color-dark);
    border-radius: 50px;
}

.img-user img{
    width: 200px;
    height: auto;
}

ul.perso{
    padding: 0;
    margin: 0;
}

.perso li{
    list-style: none;
    cursor: pointer;
    text-align: center;
    padding: 15px 10px;
    border-bottom: 1px solid var(--color-dark);
    color: var(--color-dark);
}

.perso li:hover{
    background-color: var(--color-info-dark);
}
.perso li:last-child{
    border-bottom: none;
}

button.notification{
    position: relative;
}

button.notification span{
    background: rgb(189, 17, 17);
    border-radius: 50%;
    padding: 2.5px 10px;
    text-align: center;
    position: absolute;
    top: -15px;
    right: -5px;
}

</style>
