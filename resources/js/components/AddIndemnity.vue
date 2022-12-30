<template>
    <div>
        <tr>
            <td><input type="text" class="form-control" v-model="designation" @input="emitData()"></td>
            <td><input type="number" class="form-control" v-model="montant" @input="emitData()"></td>
        </tr>
    </div>
</template>

<script>
export default {
    props:['imposable', 'numero', 'indemnity'],
    data(){
        return{
            designation: this.indemnity.designation != null ? this.indemnity.designation : '',
            montant: this.indemnity.montant != null ? this.indemnity.montant : '',
        }
    },
    methods:{
        emitData(){
            this.$emit("indemnity_data", {
                numero: this.numero,
                designation:this.designation,
                montant: this.montant
            })
        }
    },
    created(){
        console.log(this.indemnity)
    }
}
</script>

<style scoped>
tr{
    border: none;
}
</style>
