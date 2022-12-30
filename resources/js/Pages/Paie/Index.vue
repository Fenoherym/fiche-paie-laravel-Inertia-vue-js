<template>
    <div>
        <div class="container mt-5">
            <div class="header_links d-flex align-items-center py-3"
                v-if="user.role.name.toLowerCase() === 'admin'.toLowerCase() ">
                <Link href="/paies" class="me-2">Liste</Link>/
                <Link href="/paie/create" class="me-2 ms-2">Ajouter</Link>/
            </div>
            <div class="row">
                <div class="col-md-2">
                    <select class="form-select form-select" aria-label=".form-select-sm example" v-model="page_size">
                        <option value="5" selected>5</option>
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="30">30</option>
                    </select>
                </div>
                <div class="col-md-3" v-if="user.role.name.toLowerCase() === 'admin'.toLowerCase()">
                    <input type="text" placeholder="rechercher" class="form-control mb-2" v-model="q">
                </div>
                <div class="col-md-3">
                    <input type="month" class="form-control mb-2" v-model="mois">
                </div>
                <div class="col-md-3" v-if="user.role.name.toLowerCase() === 'admin'.toLowerCase()">
                    <button class="btn btn-success" :disabled="generateButtonDisabled">
                        <Link href="/paie/generate" class="text-white"><i class="fa-solid fa-circle-plus"></i> Génerer
                        paie du mois</Link>
                    </button>
                </div>
                <div class="col-md-1" v-if="user.role.name.toLowerCase() === 'admin'.toLowerCase()">
                    <Link href="/paie/create" class="btn btn-success"><i class="fa fa-plus"></i></Link>
                </div>
                <div class="col-md-4 mb-2" v-if="user.role.name.toLowerCase() === 'admin'.toLowerCase()">
                    <button class="btn btn-danger" @click="deletePaiesMonth" :disabled="deleteButtonDisabled"><i
                            class="fa-solid fa-trash"></i> Supprimer les paies du mois</button>
                </div>
            </div>
            <div class="_card">
                <div class="card">
                    <div class="card-header">
                        Listes des fiches
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nom etPrénom</th>
                                    <th>Mois</th>
                                    <th v-if="user.role.name.toLowerCase() === 'admin'.toLowerCase() ">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-if="user.role.name.toLowerCase() === 'admin'.toLowerCase() ">
                                    <tr v-for="bulletin in paginate(page_size, page_number)" :key="bulletin.id">
                                        <td><a :href="`/paie/${bulletin.id}`" target="_blank">{{ bulletin.personnel.name + ' ' +bulletin.personnel.first_name
                                        }}</a> </td>
                                        <td>{{ bulletin.mois }}</td>
                                        <td>
                                            <Link :href="`/paie/edit/${bulletin.id}`" class="btn btn-primary me-2">
                                            <i class="fa-solid fa-pen-to-square"></i></Link>
                                            <button @click="deletePaie(bulletin.id)" class="btn btn-danger">
                                                <i class="fa-solid fa-trash"></i></button>
                                        </td>
                                    </tr>
                                </template>
                                <template v-else>
                                    <tr v-for="bulletin in getFilteredPaie()" :key="bulletin.id">
                                        <td><a :href="`/paie/${bulletin.id}`" target="_blank">{{ bulletin.personnel.name
                                        + ' ' + bulletin.personnel.first_name
                                        }}</a> </td>
                                        <td>{{ bulletin.mois }}</td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                        <div class="alert alert-danger"
                            v-if="Object.keys(bulletins).length == 0 && user.role.name.toLowerCase() === 'admin'.toLowerCase()">
                            Aucun résultat
                        </div>
                        <div class="alert alert-danger"
                            v-if="Object.keys(getFilteredPaie()).length == 0 && user.role.name.toLowerCase() !== 'admin'.toLowerCase()">
                            Vous n'avez pas encore de fiche de paie
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-3">
                <Pagination :itemsPerPage="page_size" :total-items="totalItems" @change-page="changePage" />
            </div>
        </div>
    </div>
</template>

<script>

import MainLayout from '../../Layout/MainLayout.vue';
import { Link } from '@inertiajs/inertia-vue3';
import { usePage } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import { createToaster } from '@meforma/vue-toaster';
import Pagination from '../../components/Pagination.vue';
export default {
    layout: MainLayout,
    components: {
        Link,
        Pagination
    },
    props: ['bulletins', 'auth.user'],
    data() {
        return {
            page_size: 5,
            page_number: 1,
            ItemsPerPage: 1,
            totalItems: this.bulletins.length,
            q: '',
            mois: '',
            generateButtonDisabled: true,
            deleteButtonDisabled: true
        }
    },
    created() {
        this.user = usePage().props.value.auth.user
        this.disabledButtonActive()
    },
    methods: {
        getFilteredPaie() {
            return this.bulletins.filter(
                bulletin => {
                    return bulletin.personnel.email === this.user.email && bulletin.mois.toLowerCase().includes(this.mois.toLowerCase())
                }
            )
        },
        deletePaie(id) {
            let ok = confirm("Souhaitez vous confirmer la suppression de ce bulletin")
            if (ok) {
                this.toaster = createToaster({})
                let url = `/paie/delete/${id}`
                Inertia.get(url)

                this.toaster.success("Bulletin supprimé avec succès")
            } else {
                this.toaster.success("Bulletin non supprimé")
            }
        },
        paginate(page_size, page_number) {
            return this.getPaies().slice((page_number - 1) * page_size, page_number * page_size);
        },
        getPaies() {
            return this.bulletins.filter(
                bulletin => {
                    return (bulletin.personnel.name.toLowerCase().includes(this.q.toLowerCase()) ||
                        bulletin.personnel.first_name.toLowerCase().includes(this.q.toLowerCase())) && bulletin.mois.toLowerCase().includes(this.mois.toLowerCase())
                }
            )
        },
        changePage(page) {
            this.page_number = page
        },
        disabledButtonActive() {
            let mois = new Date().getMonth();
            let actual_paie = this.bulletins.filter(
                bulletin => {
                    return new Date(bulletin.mois).getMonth() == mois
                }
            )

            if (actual_paie.length == 0) {
                this.generateButtonDisabled = false
                this.deleteButtonDisabled = true
            } else {
                this.generateButtonDisabled = true
                this.deleteButtonDisabled = false
            }
        },
        deletePaiesMonth() {
            let url = '/paies/delete/month'
            Inertia.delete(url)
            this.deleteButtonDisabled = true
            this.generateButtonDisabled = false
        }
    },


}
</script>

<style>

</style>
