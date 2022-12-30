<template>
    <div>
                <!-- Button trigger modal -->
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#create-contrat">
           <i class="fa fa-plus"></i>
        </button>

        <!-- Modal -->
        <div class="modal fade" id="create-contrat" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="name">Contrat</label>
                    <input type="text" class="form-control" id="name" v-model="form.name">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="btn-close" data-bs-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-primary" @click="createContrat()">Enregistrer</button>
            </div>
            </div>
        </div>
        </div>
    </div>
</template>

<script>
import { Inertia } from '@inertiajs/inertia';
export default {
    data(){
        return{
            form:{
                name: ''
            }
        }
    },
    methods:{
        createContrat(){
            let url = '/contrat/store'
            let formData = new FormData();
            formData.append("name", this.form.name)

            Inertia.post(url, formData)

            let close_btn = document.querySelector("#btn-close")
            close_btn.click()

            this.form.name= ''
        }
    }
}
</script>

<style>

</style>
