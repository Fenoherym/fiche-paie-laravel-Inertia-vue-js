<template>
  <div>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#logo">
            Changer le logo
        </button>

        <!-- Modal -->
        <div class="modal fade" id="logo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Changer logo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="formFile" class="form-label">Default file input example</label>
                    <input class="form-control" ref="file" type="file" id="formFile"  @change="onFileChange">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="changeLogoClose" data-bs-dismiss="modal">fermer</button>
                <button type="button" class="btn btn-primary" @click="changeLogo">Save Enregistrer</button>
            </div>
            </div>
        </div>
        </div>
  </div>
</template>

<script setup>
import { Inertia } from '@inertiajs/inertia';
import { ref } from '@vue/reactivity';

const props = defineProps(['errors'])

const logoUrl = ref('')
const onFileChange = async (e) =>{
    logoUrl.value = e.target.files[0] || e.dataTransfer.files[0]
    console.log(logoUrl)
}

const changeLogo = () => {
    let url = 'logo/change'
    let formData = new FormData()
    formData.append("logoUrl", logoUrl.value)
    Inertia.post(url, formData)

    let btnClose = document.querySelector('#changeLogoClose')
    btnClose.click()
    logoUrl.value = null
}
</script>

<style>

</style>
