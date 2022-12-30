<template>
    <div>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" :data-bs-target="`#exampleModal${contrat.id}`">
          <i class="fa fa-edit"></i>
        </button>

        <!-- Modal -->
        <div class="modal fade" :id="`exampleModal${contrat.id}`" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modification contrat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="name">Contrat</label>
                    <input type="text" class="form-control" id="name" v-model="form.name">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" :id="`close-btn${contrat.id}`" data-bs-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-primary" @click="updateContrat()">Enregistrer</button>
            </div>
            </div>
        </div>
        </div>
    </div>
</template>

<script>
import { Inertia } from '@inertiajs/inertia';
export default {
    props: ['contrat'],
    data(){
        return{
            form:{
                name: this.contrat.name
            }
        }
    },
    methods:{
        updateContrat(){
            let url = '/contrat/update'

            let formData = new FormData();
            formData.append("id", this.contrat.id)
            formData.append("name", this.form.name)

            Inertia.post(url, formData)

            let close_btn = document.querySelector(`#close-btn${this.contrat.id}`)
            close_btn.click()
        }
    }

}
</script>

<style>

</style>
