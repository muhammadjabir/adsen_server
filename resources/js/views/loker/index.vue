<template>
    <v-app>
        <Progress v-if="loading"/>
        <v-container v-if="!loading">
            <BtnJudul text="Courses Management" />
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
                            <th class="text-left">judul</th>
                            
                            <th class="text-left">Status</th>
                            <th class="text-left">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in data" :key="item.id">
                                <!-- <td class="text-left">

                                <v-img :src="item.foto_courses" height="80px" width="80px"></v-img>

                                </td> -->
                                <td class="text-left">{{item.judul}}</td>
                                
                                <td class="text-left">
                                    <v-btn color="" x-small dark v-if="item.status == 0" @click="ChangeStatus(item.id)" :loading="item.loading ? item.loading : false" >
                                        Non-Active
                                    </v-btn>

                                     <v-btn color="success" x-small dark v-if="item.status == 1" @click="ChangeStatus(item.id)" :loading="item.loading ? item.loading : false" >
                                        Active
                                    </v-btn>
                                </td>
                                <td class="text-left">
                                <v-btn color="success" v-on:click="edit(item.id)" fab x-small dark >
                                    <v-icon>mdi-circle-edit-outline</v-icon>
                                </v-btn>
                                <v-btn color="error" fab x-small @click="dialogDelete(item.id)" >
                                    <v-icon>mdi-delete-outline</v-icon>
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

            <v-dialog
            v-model="dialog"
            max-width="340"
            >
            <v-card>
                <v-card-title >Apa anda yakin menghapus ?</v-card-title>

                <v-card-actions>
                <v-spacer></v-spacer>

                <v-btn

                    text
                    @click="dialog = false"
                >
                    Cancel
                </v-btn>

                <v-btn
                    color="red"
                    text
                    @click="deleteData()"
                >
                    Delete
                </v-btn>
                </v-card-actions>
            </v-card>
            </v-dialog>
        </v-container>
    </v-app>

</template>
<script>

import CrudMixin from '../../mixins/CrudMixin'
export default {
    name: 'lokers',
    mixins:[CrudMixin],

    methods:{
        async ChangeStatus(id){
            let courses = this.data.find(x => x.id === id)
            let index = this.data.findIndex(x => x.id === id)
            courses.loading = true
            this.data.splice(index,1,courses)
            let data = new FormData()
            data.append('id',id)
            let url = window.location.pathname + '/status'
            await this.axios.post(url,data,this.config)
            .then((ress) => {
                courses.status = !courses.status
                courses.loading = false
                this.data.splice(index,1,courses)

            })
            .catch((err) => {
                console.log(err.response)


            })

            this.data[index].loading = false
        }
    },
}
</script>

