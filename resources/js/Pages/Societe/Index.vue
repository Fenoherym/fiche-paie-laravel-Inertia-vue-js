<template>
    <div>
        <div class="container">
            <h4>Informations sur l'entreprise</h4>
            <div class="_card">
                <div class="card">
                </div>
            </div>
            <div class="_card mt-3 mb-2" v-if="updateCardActive">
                <div class="card">
                    <div class="card-header">
                        Modification des paramètres
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row g-3 align-items-center">
                                    <div class="col-3 text-end mb-3">
                                        <label for="name" class="col-form-label">Nom du societe:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="texte" id="name" class="form-control" aria-describedby="passwordHelpInline" v-model="form.name">
                                    </div>
                                </div>
                                <div class="row g-3 align-items-center">
                                    <div class="col-3 text-end mb-3">
                                        <label for="name" class="col-form-label">adresse:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="texte" id="name" class="form-control" aria-describedby="passwordHelpInline" v-model="form.adresse">
                                    </div>
                                </div>
                                <div class="row g-3 align-items-center">
                                    <div class="col-3 text-end mb-3">
                                        <label for="name" class="col-form-label">NIF:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="number" id="name" class="form-control" aria-describedby="passwordHelpInline" v-model="form.NIF">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row g-3 align-items-center">
                                    <div class="col-3 text-end mb-3">
                                        <label for="name" class="col-form-label">STAT:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="number" id="name" class="form-control" aria-describedby="passwordHelpInline" v-model="form.STAT">
                                    </div>
                                </div>
                                <div class="row g-3 align-items-center">
                                    <div class="col-3 text-end mb-3">
                                        <label for="name" class="col-form-label">Tel:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="tel" id="name" class="form-control" aria-describedby="passwordHelpInline" v-model="form.tel">
                                    </div>
                                </div>
                                <div class="row g-3 align-items-center">
                                    <div class="col-3 text-end mb-3">
                                        <label for="name" class="col-form-label">Email:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="email" id="name" class="form-control" aria-describedby="passwordHelpInline" v-model="form.tel">
                                    </div>
                                </div>

                            </div>
                            <div class="row g-3 align-items-center ms-5">
                                <div class="col-1 text-end mb-3">
                                    <label for="name" class="col-form-label">A-propos:</label>
                                </div>
                                <div class="col-md-9">
                                    <textarea class="form-control"  rows="5" v-model="form.about"></textarea>

                                </div>
                            </div>
                            <div class="form-group d-flex justify-content-end mt-3">
                                <button class="btn btn-danger me-3" @click=" closeCard()">Annuler</button>
                                <button class="btn btn-primary" @click=" updateSociete()">Enregistrer</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="_card mt-3 mb-3">
                <div class="card p-3">
                    <div class="row">
                        <div class="col-md-6">
                            <h2>{{ societe.name }}</h2>
                            <h6>{{ societe.adresse }}</h6>
                            <h6>NIF: {{ societe.NIF }}</h6>
                            <h6>STAT: {{ societe.STAT }}</h6>
                            <h6>Tel: {{ societe.tel }}</h6>
                            <h6>email: {{ societe.email }}</h6>
                        </div>
                        <div class="col-md-6">
                            <p>
                               {{ societe.about }}
                            </p>
                        </div>
                    </div>
                    <div class="row p-3">
                        <div class="col-md-4">
                            <button class="btn btn-success me-3" @click="updateCardToggle()"><i class="fa-solid fa-wrench"></i> Modifier les paramètres</button>
                        </div>
                        <div class="col-md-3">
                            <ChangeLogo />
                        </div>
                    </div>
                </div>
            </div>

            <div class="_card mt-3 mb-3" v-if="serviceActive">
                <div class="card p-3">
                    <div class="card-header">
                        Modificaiton service et poste de travail
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h4>Service</h4>
                                <div class="row g-3 align-items-center mb-3">
                                    <div class="col-4 text-end">
                                        <label for="name" class="col-form-label">Nom du service:</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="texte" id="name" class="form-control" aria-describedby="passwordHelpInline" v-model="service.name" >
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h4>Postes de travail</h4>
                                <div class="row g-3 align-items-center mb-3" v-for="workplace in workplaceForm" :key="workplace.id">
                                    <div class="col-4 text-end">
                                        <label for="name" class="col-form-label">Poste de travail:</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="texte" id="name" class="form-control" aria-describedby="passwordHelpInline" v-model="workplace.name">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group d-flex justify-content-end mt-3">
                            <button class="btn btn-danger me-3" @click=" closeServiceCard()">Annuler</button>
                            <button class="btn btn-primary" @click=" updateService(service.id)">Enregistrer</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="_card mb-5">
                <div class="card p-3">
                    <div class="row">
                        <div class="col-md-3">
                            <Link href="/societe/service/create" class="btn btn-success"><i class="fa-solid fa-plus"></i></Link>
                        </div>
                    </div>
                    <div class="row">
                        <h2>Services</h2>
                        <div class="col-md-6" v-for="establishment in societe.establishments" :key="establishment.id">
                             <div class="row  my-3">
                                <div class="col-md-8">
                                    <h4>{{ establishment.name }}</h4>
                                </div>
                                <div class="col-md-4">
                                    <Link class="text-dark" @click="deleteService(establishment.id)"><i class="fa-solid fa-trash"></i></Link> <button class="btn" @click="editService(establishment.id)"><i class="fa-solid fa-edit"></i></button>
                                </div>
                             </div>
                            <ul>
                                <div class="row" v-for="workplace in establishment.workplaces" :key="workplace.id">
                                    <div class="col-md-8" >
                                        <li><i class="fa-solid fa-arrow-right"></i> {{ workplace.name }}</li>
                                    </div>
                                    <div class="col-md-4">
                                        <Link class="text-dark" :href="`/societe/workplace/delete/${workplace.id}`"><i class="fa-solid fa-trash"></i></Link>
                                    </div>
                                </div>
                            </ul>
                        </div>
                        <hr>
                        <h4>Types de contrat</h4>
                        <Create />
                        <table class="table text-center">
                            <thead>
                                <tr>
                                    <th>Contrat</th>
                                    <th>Supprimer</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="contrat in contrats" :key="contrat.id">
                                    <td>{{ contrat.name }}</td>
                                    <td class="d-flex justify-content-center">
                                        <Edit :contrat="getContrat(contrat.id)" />
                                        <button class="btn btn-danger ms-2" @click="deleteContrat(contrat.id)"><i class="fa-solid fa-trash"></i> </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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
import { createToaster } from '@meforma/vue-toaster'
import Edit from  './Contrat/Edit'
import Create from './Contrat/Create.vue'
import ChangeLogo from './ChangeLogo.vue'
export default {
    layout: MainLayout,
    props: ['societe', 'contrats'],
    components:{
        Link,
        Edit,
        Create,
        ChangeLogo
    },
    data(){
        return{
            updateCardActive: false,
            form:{
                name: this.societe.name,
                about: this.societe.about,
                adresse: this.societe.adresse,
                NIF: this.societe.NIF,
                STAT: this.societe.STAT,
                tel: this.societe.tel,
                email: this.societe.email
            },
            service: null,
            serviceActive: false,
            workplaceForm: []
        }
    },
    methods:{
        updateCardToggle(){
            this.updateCardActive ^= true
        },
        updateSociete(){
            let url =`societe/update/${this.societe.id}`
            let formData = new FormData()
            formData.append("name", this.form.name)
            formData.append("about", this.form.about)
            formData.append("adresse", this.form.adresse)
            formData.append("NIF", this.form.NIF)
            formData.append("STAT", this.form.STAT)
            formData.append("tel", this.form.tel)
            formData.append("email", this.form.email)

            Inertia.post(url, formData)
            this.updateCardActive = false
        },
        closeCard(){
            this.updateCardActive = false

        },
        editService(id){
            this.service = this.societe.establishments.find(
                service => service.id == id
            )
            this.serviceActive= true
           this.service.workplaces.forEach(workplace => {
                this.workplaceForm.push(workplace)
           });

           console.log(this.workplaceForm)
        },
        updateService(id){
            let formData = new FormData();
            formData.append("name", this.service.name)
            formData.append("workplaceForm", JSON.stringify(this.workplaceForm))

            let url = `/societe/service/update/${id}`
            Inertia.post(url, formData);
            this.closeServiceCard();
        },
        closeServiceCard(){
            this.service = null
            this.workplaceForm = []
            this.serviceActive = false
        },
        deleteService(id){
            this.toaster = createToaster({})
            let ok = confirm("ATTENTION!!!: La suppression de ce service implique la suppression de tous les postes de travail qui lui sont associé, et chaque poste peut être associé à un employé.");
            if(ok){
                let url = `/societe/service/delete/${id}`
                Inertia.get(url)
                this.toaster.success("Service supprimé avec succès")
            }else{
                this.toaster.warning("Service non supprimé");
            }
        },
        getContrat(id){

            return this.contrats.find(
                contrat => contrat.id === id
            )
        },
        deleteContrat(id){
            this.toaster = createToaster({})
            let url =`/contrat/delete/${id}`

            let ok = confirm("ATTENTION!!! un contrat peut être associé à des employés. Voulez vous confirmer la suppression ??")
            if(ok){
                Inertia.get(url)
                this.toaster.success("Contrat supprimé")
            }else{
                this.toaster.success("Contrat non supprimé")
            }
        }
    },
    created(){
       console.log(this.getContrat(2))
    }
}
</script>

<style scoped>
h2, h6, h4, li{
    color: var(--color-dark);
}
ul, li{
    padding: 0;
}
li{
    list-style: none;
}
.add-btn{
    border: none;
    background: var(--color-background);
    font-size: 20px;
    display: flex;
    justify-content: center;
    color: var(--color-dark);
}
</style>
