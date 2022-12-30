<template>
    <div>
        <div class="container">
            <div class="header_links d-flex align-items-center py-3">
                <Link href="/rubriques" class="me-2">Liste</Link>/
                <Link href="/rubrique/create" class="me-2 ms-2">Ajouter</Link>/
            </div>
            <div class="d-flex mb-3">
                <Link href="/rubrique/create" class="btn btn-success me-3"><i class="fa fa-plus"></i> Ajouter un rubrique</Link>
                <Irsas :irsas="irsas"/>
            </div>
            <div class="_card mb-5">
                <div class="card">
                    <div class="card-header">Liste des rubriques</div>
                    <div class="card-ody">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Numero</th>
                                    <th scope="col">Designation</th>
                                    <th scope="col">Valeur de base</th>
                                    <th scope="col">Taux part salarial</th>
                                    <th scope="col">Taux part patronal</th>
                                    <th>Type</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="rubrique in rubriques" :key="rubrique.id">
                                    <th scope="row">{{ rubrique.numero }}</th>
                                    <td>{{ rubrique.designation }}</td>
                                    <td>{{ rubrique.base }}</td>
                                    <td>{{ rubrique.taux_part_salarial }}</td>
                                    <td>{{ rubrique.taux_part_patronal }}</td>
                                    <td>{{ rubrique.type }}</td>
                                    <td>

                                        <Link :href="`/rubrique/edit/${rubrique.id}`" class="btn btn-primary m-1 btn-actions"><i class="fa fa-edit"></i></Link>
                                        <button class="btn btn-danger m-1 btn-actions" @click="deleteRubrique(rubrique.id)"><i class="fa fa-trash"></i></button>
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

import MainLayout from '../../Layout/MainLayout.vue';
import { Inertia } from '@inertiajs/inertia';
import { createToaster } from '@meforma/vue-toaster';
import { Link } from '@inertiajs/inertia-vue3';
import Irsas from './Irsas.vue';

export default {
    layout:MainLayout,
    components:{
        Link,
        Irsas
    },
    props: ['rubriques', 'irsas'],
    methods:{
        deleteRubrique(id){
            this.toaster = createToaster({})
            let url = `/rubrique/delete/${id}`
            let ok = confirm("Etes vous sur de vouloir supprimer cette rubrique?")
            if(ok){
                Inertia.get(url)
                this.toaster.success("Rubrique supprimé avec succès");
            }else{
                this.toaster.warning("Rubrique non supprimé")
            }

        }
    }
}
</script>

<style>
    .header_links a, .header_links{
        font-weight: 500;
        color: var(--color-info-dark)
    }
</style>
