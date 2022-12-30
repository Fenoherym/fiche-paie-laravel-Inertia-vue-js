<template>
    <div>
        <div class="container">
            <div class="_card">
                <div class="card">
                    <div class="card-header">
                        Modification d'un rubrique
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row g-3 align-items-center">
                                    <div class="col-3 text-end mb-3">
                                        <label for="name" class="col-form-label">Numero:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="number" id="name" class="form-control" :class="{ 'is-invalid': errors.numero != null}" aria-describedby="passwordHelpInline" v-model="form.numero">
                                        <div class="invalid-feedback" v-if="errors.numero != null">
                                            {{ errors.numero }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group d-flex justify-content-end">
                                <button class="btn btn-primary" @click="postRubrique">Enregistrer</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import MainLayout from '../../Layout/MainLayout.vue'
export default {
    layout: MainLayout,
    props:['errors']
}
</script>

<style>

</style>
