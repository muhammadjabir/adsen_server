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
                            <th class="text-left">Image</th>
                            <th class="text-left">Name Courses</th>
                            <th class="text-left">Category</th>
                            <th class="text-left">Harga</th>
                            <th class="text-left">Diskon</th>
                            <th class="text-left">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in data" :key="item.id">
                                <td class="text-left">

                                <v-img :src="item.foto_courses" height="80px" width="80px"></v-img>

                                </td>
                                <td class="text-left">{{item.name}}</td>
                                <td class="text-left">{{item.category.description}}</td>
                                <td class="text-left">{{item.harga | formatPrice}}</td>
                                <td class="text-left">{{item.diskon}}%</td>
                                
                                <td class="text-left">
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
    name: 'courses',
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
    filters:{
        formatPrice(value) {
        let val = (value/1).toFixed(2).replace('.', ',')
        return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
        }
    }
}
</script>

