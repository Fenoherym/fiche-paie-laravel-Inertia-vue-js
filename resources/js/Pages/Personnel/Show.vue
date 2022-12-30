<template>
    <div>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" :data-bs-target="`#staticBackdrop${personnel.id}`">
            <i class="fa-solid fa-eye"></i>
        </button>

        <!-- Modal -->
        <div class="modal fade" :id="`staticBackdrop${personnel.id}`" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Informations</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h4>{{ personnel.name + ' ' + personnel.first_name }}</h4>
                        <p><span>Email:</span> {{ personnel.email }}</p>
                        <p><span>Tel:</span> {{ personnel.telephone }}</p>
                        <p><span>Sexe:</span> {{ personnel.sexe }}</p>
                        <p><span>date de naissance:</span> {{ personnel.birthday }}</p>
                        <p><span>Salaire de base:</span> {{ personnel.base_salary }}</p>
                        <p><span>Nombre d'enfant:</span> {{ personnel.number_children }}</p>
                        <p><span>Statut:</span> {{ personnel.statut.name }}</p>
                        <p><span>Poste occupé:</span> {{ personnel.workplace.name }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['personnel']
}
</script>

<style scoped>
    .modal-body p span{
        font-weight: 600;
        font-size: 1.1rem;
    }
</style>
