<template>
    <v-app>
        <Progress v-if="loading"/>
       
        <v-container v-if="!loading">
            
            <v-card
            class="border-edit"
            tile
            >
                <BtnJudul :text="'Video Courses ' + $route.params.slug" />
                <v-card-text>
                    <v-container>

                        <v-text-field
                        v-model="keyword"
                        label="Cari Video"
                         v-on:keyup = "go"
                                color="drey darken-4"
                        ></v-text-field>


                    </v-container>

                </v-card-text>

                <v-card-actions class="">

                </v-card-actions>
            </v-card>
            <v-row>
                <v-col  cols="12"
                md="4"
                 v-for="item in data" :key="item.id" >
                <v-card
           
                >
                <video controlslist="nodownload" width="100%" controls :src="item.link" @click="view(item.link,item.judul)">
                            
                </video>
                
                <v-card-title>{{item.judul}}</v-card-title>
                </v-card>
                </v-col>
                
            </v-row>

            <div class="text-center">
                    <v-pagination
                    v-model="page"
                    :length="lengthpage"
                    :total-visible="7"
                    @input="go"
                    color="grey darken-4"
                    ></v-pagination>
            </div>
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

