<template>
    <v-app>
        <v-container>
            <BtnJudul text="Create Courses" />

            <v-card
            class="border-edit"
            tile
            >
                <!-- <v-card-text class="text-center"> -->
                <v-card-text>
                    <v-container>
                        <v-row>
                            <v-col
                            cols="12"
                            md="4"
                            order-sm="last"
                            order-md="first"
                            >
                            <v-img style="cursor:pointer" :src="imgurl" @click="$refs.foto_profile.click()" height="300px"></v-img>
                            </v-col>


                            <v-col
                            cols="12"
                            md="8"

                            >
                            <v-form
                                ref="form"
                                v-model="valid"
                                :lazy-validation="lazy"
                                >
                                <input type="file" style="display:none; " id="foto_profile" ref="foto_profile" accept="image/*" @change="eventChange">
                                <label for="" align="left">New Courses</label>

                                <v-text-field
                                v-model="name"
                                :rules="nameRules"
                                label="Name"
                                required
                                ></v-text-field>

                                 <v-select
                                    v-model="select"
                                    :items="items"
                                    :rules="[v => !!v || 'Item is required']"
                                    label="Category"
                                    item-text="description"
                                    item-value="id"
                                    required
                                ></v-select>

                                 <v-text-field
                                v-model="harga"
                                :rules="nameRules"
                                label="Harga Course"
                                required
                                ></v-text-field>

                                <v-text-field
                                v-model="diskon"
                                :rules="nameRules"
                                label="Diskon"
                                required
                                ></v-text-field>


                                <v-row>
                                    <v-col
                                    cols="12"
                                    align="right"
                                    >
                                    <v-btn
                                        :disabled="!valid"
                                        color="success"
                                        tile
                                        @click="save()"
                                        :loading="loading"
                                        >
                                        Save
                                        </v-btn>
                                    </v-col>
                                </v-row>
                            </v-form>
                            </v-col>
                        </v-row>

                    </v-container>

                </v-card-text>

                <v-card-actions class="">

                </v-card-actions>
            </v-card>
        </v-container>
    </v-app>

</template>
<script>
// import {mapActions} from 'vuex'
import CoursesMixin from '../../mixins/CoursesMixin'
export default {
    name: 'masterdata.edit',
    data: () => ({
        imgurl:'http://localhost:8000/storage/default/icon_admin.jpg',
        foto:''

   }),

    mixins:[CoursesMixin],
    methods:{
        async save(){
            this.loading = true
            let url = window.location.pathname
            url = url.split('/')
            url = `${url[1]}/${url[2]}`
            let data = new FormData()
            data.append('name',this.name)
            data.append('foto' , this.foto)
            data.append('id_category' , this.select)
            data.append('harga' , this.harga)
            data.append('diskon' , this.diskon)
            data.append('_method','PUT')

            await this.axios.post(url,data,this.config)
            .then((ress) => {
                console.log(ress)
                this.setSnakbar({
                    status:true,
                    pesan:ress.data.message,
                    color:'success'
                })
                this.$router.go(-1)
            })
            .catch((err)=>{
                if (err.response.status == 401 ) {
                    this.setSnakbar({
                    color:'red',
                    status:true,
                    pesan:err.response.data.message,
                    })
                }else{
                    this.setSnakbar({
                    status:true,
                    color:'red',
                    pesan:"Terjadi Kesalahan",
                    })
                }

                console.log(err.response)
            })
            this.loading = false

        },

        eventChange(event){
            const files = event.target.files
            this.foto = files[0]
             const fileReader = new FileReader()
            fileReader.addEventListener('load',()=>{
                this.imgurl=fileReader.result
            })
             fileReader.readAsDataURL(this.foto)
        },

        go(){
         let url = window.location.pathname
         this.axios.get(url,this.config)
         .then((ress) => {
             let courses = ress.data.courses
             this.name = courses.name
             this.select = courses.id_category
             this.imgurl = courses.foto_courses ? courses.foto_courses : this.imgurl

             this.items = ress.data.category
             this.harga = courses.harga
             this.diskon = courses.diskon
         })
         .catch((err) => console.log(err.response))
        }

    },

    created(){
        this.go()
    }

}
</script>

<style lang="css" scoped>
</style>
