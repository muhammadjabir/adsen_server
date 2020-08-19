<template>
    <v-app>
        <Progress v-if="loading"/>
        <v-container v-if="!loading">
            <BtnJudul text="Class Management" />
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
                                label="Pencarian"
                                v-on:keyup = "go"
                                color="drey darken-4"
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
                            <th class="text-left">Class Name</th>
                            <th class="text-left">Courses</th>
                            <th class="text-left">Trainer</th>
                            <th class="text-left">Total Students</th>
                            <th class="text-left">Status</th>
                            <th class="text-left">Pendaftaran</th>
                            <th class="text-left">Awal Pendaftaran</th>
                            <th class="text-left">Akhir Pendaftaran</th>
                            <th class="text-left">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in data" :key="item.id">
                                <td class="text-left" >

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
                                    <v-list-item>
                                    <v-list-item-avatar>
                                        <v-img :src="item.trainer.foto_profile ? item.trainer.foto_profile : this.urlDefault + 'storage/defaultprofile.jpg'"></v-img>
                                    </v-list-item-avatar>

                                    <v-list-item-content>
                                        {{item.trainer.name}}
                                    </v-list-item-content>
                                    </v-list-item>
                                </td>
                                <td class="text-center">{{item.total_students}}</td>
                                <td class="text-left">
                                    <v-btn color=""x-small dark v-if="item.status == 0" @click="ChangeStatus(item.id,'status')" :loading="item.loading ? item.loading : false" >
                                        Non-Active
                                    </v-btn>

                                     <v-btn color="success"x-small dark v-if="item.status == 1" @click="ChangeStatus(item.id,'status')" :loading="item.loading ? item.loading : false" >
                                        Active
                                    </v-btn>
                                </td>

                                 <td class="text-left">
                                    <v-btn color="red" x-small dark v-if="item.status_pendaftaran == 0" @click="ChangeStatus(item.id,'pendaftaran')" :loading="item.loading_pendaftaran ? item.loading_pendaftaran : false" >
                                        Closed
                                    </v-btn>

                                     <v-btn color="success"x-small dark v-if="item.status_pendaftaran == 1" @click="ChangeStatus(item.id,'pendaftaran')" :loading="item.loading_pendaftaran ? item.loading_pendaftaran : false" >
                                        Open
                                    </v-btn>
                                </td>
                                <td class="text-left" >

                                {{item.awal_pendaftaran | setDate}}

                                </td>
                                <td class="text-left" >

                                {{item.akhir_pendaftaran | setDate}}

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
                <v-card-title class="headline">Apa anda yakin menghapus ?</v-card-title>
<!--
                <v-card-text>
                Let Google help apps determine location. This means sending anonymous location data to Google, even when no apps are running.
                </v-card-text> -->

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
    name: 'classmanagement',
    mixins:[CrudMixin],
    methods:{
        async ChangeStatus(id,status){
            let courses = this.data.find(x => x.id === id)
            let index = this.data.findIndex(x => x.id === id)
            
            this.data.splice(index,1,courses)
            let data = new FormData()
            data.append('id',id)
            data.append('status',status)
            if (status == 'pendaftaran') {
                courses.loading_pendaftaran = true
            } else {
                courses.loading = true
            }
            let url = window.location.pathname + '/status'
            await this.axios.post(url,data,this.config)
            .then((ress) => {
                 if (status == 'pendaftaran') {
                courses.status_pendaftaran = !courses.status_pendaftaran
                    courses.loading_pendaftaran = false
                } else {
                   courses.status = !courses.status
                    courses.loading = false
                }
                
                this.data.splice(index,1,courses)

            })
            .catch((err) => {
                console.log(err.response)


            })

            this.data[index].loading = false
        },

       
    },
    filters:{
        setDate(value){
        let data = value
        data = new Date(data)
        let bulan = data.getMonth()
        let tgl = data.getDate()
        tgl = tgl.toString().length < 2 ? `0${tgl}` : `${tgl}` 
        bulan = bulan.toString().length < 2 ? `0${bulan + 1}` : `${bulan + 1}` 
        data = `${tgl}-${bulan}-${data.getFullYear()}`
        return data
        }
    },

    created(){
       
    }
}
</script>

