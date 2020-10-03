<template>
    <v-app>
        <Progress v-if="loading"/>
        <v-container v-if="!loading">
            <v-row>
                <v-col  cols="12"
                md="4"
                 v-for="item in data" :key="item.id" >
                <v-card
               
                >
                <v-img
                class="white--black align-end"
                :src="item.foto_courses"
                height="300px"
                >
                
                </v-img>
                <v-card-title>{{item.name}}</v-card-title>
                <v-card-actions>
                <v-btn
                    color="red"
                    text
                    :to="{ name: 'student.courses.video', params:{slug:item.slug}}"
                >
                
                   Lihat Video
                </v-btn>
                </v-card-actions>
                </v-card>
                </v-col>
                
            </v-row>
        </v-container>
    </v-app>

</template>
<script>

import CrudMixin from '../../mixins/CrudMixin'
export default {
    name: 'student.menu.courses',
    mixins:[CrudMixin]
}
</script>

