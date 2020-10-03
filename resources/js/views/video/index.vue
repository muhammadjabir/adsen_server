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
                <!-- <v-card-subtitle class="pb-0">Number 10</v-card-subtitle>

                <v-card-text class="text--primary">
                <div>Whitehaven Beach</div>

                <div>Whitsunday Island, Whitsunday Islands</div>
                </v-card-text> -->

                <v-card-actions>
                <v-btn
                    color="red"
                    text
                    :to="urlcreate + '?slug=' + item.slug"
                >
                    View
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
    name: 'video',
    mixins:[CrudMixin]
}
</script>

