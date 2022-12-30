<template>
    <div class="mb-5 calendar">
        <FullCallendar :options="options" />
    </div>
</template>

<script setup>

import { reactive, ref } from 'vue'
import '@fullcalendar/core/vdom'
import FullCallendar from '@fullcalendar/vue3';
import dayGridPlugin from '@fullcalendar/daygrid'
import timeGridPlugin from '@fullcalendar/timegrid'
import listPlugin from '@fullcalendar/list'
import interactionPlugin from '@fullcalendar/interaction'

const props = defineProps(['conges'])
console.log(props.conges)
const id= ref(10)
const options = reactive({
    plugins: [dayGridPlugin, timeGridPlugin, listPlugin, interactionPlugin],
    initialView : 'dayGridMonth',
    headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right:  'dayGridMonth, dayGridWeek, listDay'
    },
    editable: true,
    selectable: true,
    weekends: true,
    events: [

  ]
})

props.conges.forEach(conge => {
    options.events.push({
        id: conge.id,
        title: `${conge.personnel.name} ${conge.personnel.first_name} ${conge.pris} jours `,
        start: conge.date_depart,
        end: conge.date_arrive
    })
})

</script>

<style scoped>

</style>
