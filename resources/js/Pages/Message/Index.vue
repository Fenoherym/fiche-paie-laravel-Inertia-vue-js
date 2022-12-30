<template>
  <div>
    <div class="_card">
       <div class="card p-3">
         <table class="table">
           <thead>
             <tr>
               <th scope="col">Message</th>
               <th>Date de demande</th>
               <th>Du</th>
               <th>AU</th>
               <th scope="col">Actions</th>
             </tr>
           </thead>
           <tbody>
              <tr v-for="message in messages" :key="message.index">
                <td>{{ message.content }}</td>
                <td>{{ formatDate(message.created_at) }}</td>
                <td>{{ formatDate(message.conge.date_depart) }}</td>
                <td>{{ formatDate(message.conge.date_arrive) }}</td>
                <td>
                    <Link class="btn btn-danger" :href="`/message/delete/${message.id}`"><i class="fa fa-trash"></i></Link>
                </td>
              </tr>

           </tbody>
         </table>
        <div class="alert alert-secondary" v-if="Object.keys(messages).length === 0">
            Vous n'avez aucuns messages
        </div>
       </div>
    </div>
  </div>
</template>

<script>

import MainLayout from '../../Layout/MainLayout.vue'
export default{
    layout: MainLayout
}
</script>

<script setup>
import { Link } from '@inertiajs/inertia-vue3';
const props = defineProps(['messages']);

const formatDate = (date) => {
    return new Date(date).toLocaleDateString('fr', { weekday:"long", year:"numeric", month:"short", day:"numeric"})
}

</script>

<style>

</style>
