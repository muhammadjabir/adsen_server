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
                                <label for="" align="left">Edit Lead</label>

                                <v-text-field
                                v-model="name"
                                :rules="requiredRules"
                                label="Name"
                                required
                                ></v-text-field>

                                <v-text-field
                                v-model="email"
                                :rules="requiredRules"
                                label="Email"
                                required
                                ></v-text-field>

                                 <v-text-field
                                v-model="nohp"
                                :rules="requiredRules"
                                label="Nomor Handphone"
                                required
                                ></v-text-field>

                                 <v-text-field
                                v-model="nowa"
                                :rules="requiredRules"
                                label="Nomor Whatsapp"
                                required
                                ></v-text-field>

                                <v-select
                                    v-model="kelas_pilihan"
                                    :items="kelas"
                                    label="Class"
                                    item-text="name"
                                    item-value="id"
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
import LeadsMixin from '../../mixins/LeadsMixin'
export default {
    name: 'leadmixin.edit',
    data: () => ({
        imgurl: 'storage/default/icon_admin.jpg',
        foto:''

   }),

    mixins:[LeadsMixin],
    methods:{
        async save(){
            this.loading = true
            let url = window.location.pathname
            url = url.split('/')
            url = `${url[1]}/${url[2]}`
            let data = new FormData()
            data.append('_method','PUT')
            data.append('nama',this.name)
            data.append('nowa' , this.nowa)
            data.append('nohp',this.nohp)
            data.append('email',this.email)
            data.append('kelas', this.kelas_pilihan)

            await this.axios.post(url,data,this.config)
            .then((ress) => {
                console.log(ress)
                this.setSnakbar({
                    status:true,
                    pesan:ress.data.message,
                    color:'success'
                })
                this.$router.push('/leads')
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

        go(){
         let url = window.location.pathname
         this.axios.get(url,this.config)
         .then((ress) => {
             let lead = ress.data.lead
             this.name = lead.nama
             this.email = lead.email
             this.kelas_pilihan = lead.kelas
             this.nohp = lead.nohp
             this.nowa = lead.nowa
             this.kelas = ress.data.kelas
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
