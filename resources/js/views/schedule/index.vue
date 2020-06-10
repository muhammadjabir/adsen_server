<template>
    <v-app>
        <Progress v-if="loading"/>
        <v-container v-if="!loading">
            <BtnJudul text="Schedule" />
            <v-card
            class="border-edit"
            tile
            >
                <v-card-text class="text-center">
                    <v-container>
                        <v-row justify="left" align="center">
                            <v-col
                                cols="6"
                            >
                            <v-text-field
                                v-model="keyword"
                                label="Search"
                                v-on:keyup = "go"
                                color="grey darken-4"
                            ></v-text-field>
                            </v-col>

                        </v-row>
                    </v-container>

                    <v-simple-table>
                        <template v-slot:default>
                        <thead>
                            <tr>
                            <th class="text-left">Class Name</th>
                            <th class="text-left">Courses</th>
                            <th class="text-left">Jam Masuk</th>
                            <th class="text-left">Jam Pulang</th>
                            <th class="text-left">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in data" :key="item.id">
                                <td class="text-left">
                                    {{item.name}}
                                </td>
                                <td class="text-left">
                                <v-list-item>
                                    <v-list-item-avatar>
                                        <v-img :src="item.courses.foto_courses? item.courses.foto_courses: this.urlDefault + 'storage/defaultprofile.jpg'"></v-img>
                                    </v-list-item-avatar>

                                    <v-list-item-content>
                                        {{item.courses.name}}
                                    </v-list-item-content>
                                </v-list-item>
                                </td>
                                <td class="text-left">
                                    {{item.jam_masuk | mencoba}}
                                </td>
                                <td class="text-left">
                                    {{item.jam_pulang | mencoba}}
                                </td>
                                <td class="text-left" width="30%">
                                    <v-btn color="primary"x-small dark @click="absen(item.id)"  >
                                        Absen
                                    </v-btn>
                                </td>
                            </tr>
                        </tbody>
                        </template>
                    </v-simple-table>
                </v-card-text>
                <div class="text-center">
                    <v-pagination
                    v-model="page"
                    :length="lengthpage"
                    :total-visible="7"
                    @input="go"
                    color="grey darken-4"
                    ></v-pagination>
                </div>
                <v-card-actions class="">

                </v-card-actions>
            </v-card>
        </v-container>
    </v-app>

</template>
<script>

import CrudMixin from '../../mixins/CrudMixin'
// import Pusher from 'pusher-js';
export default {
    name: 'trainer',
    mixins:[CrudMixin],
    filters:{
        mencoba: function (value) {
            let jam = value.split(':')
            return `${jam[0]}:${jam[2]}`
        }
    },
    methods:{
        absen(id){
            this.$router.push(`schedule/${id}/absen`)
        }
    },
    created(){
        // Pusher.logToConsole = true;

        // var pusher = new Pusher('2808afa6e874e66aa7f3', {
        // cluster: 'ap1',
        // forceTLS: true
        // });

        // var channel = pusher.subscribe('push');
        // channel.bind("my-push", function(data) {
        // // app.messages.push(JSON.stringify(data));
        // console.log(data)
        // });
    }
}
</script>

