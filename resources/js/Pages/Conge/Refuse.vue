<template>
    <div>
       <!-- Button trigger modal -->
        <button type="button" class="btn text-danger" data-bs-toggle="modal" data-bs-target="#refuseModal">
        Refuser
        </button>

        <!-- Modal -->
        <div class="modal fade" id="refuseModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="refuseModalVue" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="refuseModalVue">Pour quoi vous avez refusé?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <textarea type="text" class="form-control" placeholder="Votre message" v-model="message"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">fermer</button>
                    <button type="button" class="btn btn-primary" @click="addMessage">Envoyer</button>
                </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Inertia } from '@inertiajs/inertia';
import { createToaster } from '@meforma/vue-toaster';
import { ref } from 'vue';


const props = defineProps(['personnel_id', 'conge_id'])
const message = ref("")
const toaster = createToaster({})

const addMessage = () => {

   let url = '/message/send'
   let formData = new FormData()

   formData.append('personnel_id', props.personnel_id)
   formData.append('content', message.value)
   formData.append('conge_id', props.conge_id)

   Inertia.post(url, formData);
   document.querySelector(".btn-close").click()
   message.value = ""
   toaster.success("Votre message à été envoyé avec succès")

}



</script>

<style>

</style>
