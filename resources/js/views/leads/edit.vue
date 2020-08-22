<template>
    <v-app>
        <v-container>
            <BtnJudul text="Edit Lead" />

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
                            >
                            <v-form
                                ref="form"
                                v-model="valid"
                                :lazy-validation="lazy"
                                >
                                <input type="file" style="display:none; " id="foto_profile" ref="foto_profile" accept="image/*" @change="eventChange">
                                <label for="" align="left">Edit Lead</label>

                                <v-text-field
                                v-model="username"
                                :rules="nameRules"
                                label="Username"
                                required
                                ></v-text-field>

                                <v-text-field
                                v-model="name"
                                :rules="nameRules"
                                label="Name"
                                required
                                ></v-text-field>

                                <v-select
                                    v-model="kelamin"
                                    :items="kelamins"
                                    :rules="[v => !!v || 'Tidak Boleh Kosong']"
                                    label="Kelamin"
                                    required
                                ></v-select>

                                 <v-select
                                    v-model="kelas_student"
                                    :items="kelas"
                                    attach
                                    chips
                                    label="Class"
                                    item-text="name"
                                    item-value="id"
                                    multiple
                                ></v-select>

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
import StudentsMixin from '../../mixins/StudentsMixin'
export default {
    name: 'masterdata.edit',
    data: () => ({
        imgurl: 'storage/default/icon_admin.jpg',
        foto:''

   }),

    mixins:[StudentsMixin],
    methods:{
        async save(){
            this.loading = true
            let url = window.location.pathname
            url = url.split('/')
            url = "/" + url[1]
            let data = new FormData()
            data.append('name',this.name)
            data.append('foto' , this.foto)
            data.append('kelamin',this.kelamin)
            data.append('username',this.username)
            data.append('kelas', JSON.stringify(this.kelas_student))

            await this.axios.post(url,data,this.config)
            .then((ress) => {
                console.log(ress)
                this.setSnakbar({
                    status:true,
                    pesan:ress.data.message,
                    color:'success'
                })
                this.$router.push(url)
            })
            .catch((err)=>{
                if (err.response.status == 400 ) {
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
        }

    },

    created(){
        this.getKelas()
        this.imgurl = this.urlDefault + this.imgurl
    }

}
</script>

<style lang="css" scoped>
</style>
