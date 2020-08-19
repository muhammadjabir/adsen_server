<template>
    <v-app>
        <Progress v-if="loading"/>
        <v-container v-if="!loading">
            <BtnJudul text="Students" />
            <v-card
            class="border-edit"
            tile
            >
                <v-card-text class="text-center">
                    <v-container>
                        <v-row justify="center" align="center">
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

                            <v-col
                                cols="6"
                                align="right"
                            >
                                <v-btn color="primary"  :to="urlcreate" small tile>
                                    Create
                                </v-btn>
                            </v-col>
                        </v-row>
                    </v-container>

                    <v-simple-table>
                        <template v-slot:default>
                        <thead>
                            <tr>
                            <th class="text-left">Name</th>
                            <th class="text-left">Gender</th>
                            <th class="text-left">Class</th>
                            <th class="text-left">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in data" :key="item.id">
                                <td class="text-left">
                                <v-list-item>
                                    <v-list-item-avatar>
                                        <v-img :src="item.foto_profile ? item.foto_profile : this.urlDefault + 'storage/defaultprofile.jpg'"></v-img>
                                    </v-list-item-avatar>

                                    <v-list-item-content>
                                        {{item.name}}
                                    </v-list-item-content>
                                </v-list-item>
                                </td>
                                <td class="text-left">{{item.kelamin}}</td>

                                <td class="text-left">
                                    <ul>
                                        <li v-for="(kelas,index) in item.kelas" :key="index">
                                            {{kelas.name}}
                                        </li>
                                    </ul>

                                </td>
                                <td class="text-left" >
                              
                                <v-btn color="error" x-small @click="deletePermanent(item.id)" >
                                    Delete Permanent
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
export default {
    name: 'students',
    mixins:[CrudMixin]
}
</script>

