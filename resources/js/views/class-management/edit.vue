<template>
    <v-app>
        <v-container>
            <BtnJudul text="Edit Class" />

            <v-card
            class="border-edit"
            tile
            >
                <!-- <v-card-text class="text-center"> -->
                <v-card-text>
                    <v-container>
                        <v-form
                        ref="form"
                        v-model="valid"
                        :lazy-validation="lazy"
                        >
                            <input type="file" style="display:none; " id="foto_profile" ref="foto_profile" accept="image/*" @change="eventChange">
                            <label for="" align="left">Edit Class</label>

                            <v-text-field
                            v-model="name"
                            :rules="nameRules"
                            label="Name"
                            required
                            ></v-text-field>

                            <v-select
                                v-model="courses"
                                :items="item_courses"
                                :rules="[v => !!v || 'Item is required']"
                                label="Courses"
                                item-text="name"
                                item-value="id"
                                required
                               clearable
                                @input="eventChange"
                            >

                                <template slot="selection" slot-scope="data" >

                                    <v-list-item-avatar>
                                        <v-img :src="data.item.foto_courses"></v-img>
                                    </v-list-item-avatar>

                                    <v-list-item-content>
                                        {{ data.item.name}}
                                    </v-list-item-content>

                                </template>
                                <template slot="item" slot-scope="data" >

                                    <v-list-item-avatar>
                                        <v-img :src="data.item.foto_courses"></v-img>
                                    </v-list-item-avatar>

                                    <v-list-item-content>
                                        {{ data.item.name}}
                                    </v-list-item-content>

                                </template>
                            </v-select>

                            <v-select
                                v-model="trainer"
                                :items="item_trainers"
                                :rules="[v => !!v || 'Item is required']"
                                label="Trainer"
                                item-text="name"
                                item-value="id"
                                required
                               clearable

                            >

                                <template slot="selection" slot-scope="data" >

                                    <v-list-item-avatar>
                                        <v-img :src="data.item.foto_profile"></v-img>
                                    </v-list-item-avatar>

                                    <v-list-item-content>
                                        {{ data.item.name}}
                                    </v-list-item-content>

                                </template>
                                <template slot="item" slot-scope="data" >

                                    <v-list-item-avatar>
                                        <v-img :src="data.item.foto_profile"></v-img>
                                    </v-list-item-avatar>

                                    <v-list-item-content>
                                        {{ data.item.name}}
                                    </v-list-item-content>

                                </template>
                            </v-select>


                            <v-select
                                v-model="days"
                                :items="item_days"
                                attach
                                chips
                                label="Days"
                                item-text="description"
                                item-value="id"
                                multiple
                            ></v-select>


                            <v-row>

                                <v-col sm="12"
                                    md="6"
                                >
                                <v-menu
                                    ref="menu"
                                    v-model="menu2"
                                    :close-on-content-click="false"
                                    :nudge-right="40"

                                    transition="scale-transition"
                                    offset-y
                                    max-width="250px"
                                    min-width="250px"
                                >
                                    <template v-slot:activator="{ on }">
                                    <v-text-field
                                        v-model="time"
                                        label="Mulai"

                                        readonly
                                        v-on="on"
                                    ></v-text-field>
                                    </template>
                                    <v-time-picker
                                    v-if="menu2"
                                    v-model="time"
                                    full-width
                                    @click:minute="$refs.menu.save(time)"
                                    ></v-time-picker>
                                </v-menu>
                                </v-col>

                                <v-col sm="12"
                                    md="6"
                                >
                                <v-menu
                                    ref="menus"
                                    v-model="menu3"
                                    :close-on-content-click="false"
                                    :nudge-right="40"
                                    @click:minute="$refs.menus.save(time)"
                                    transition="scale-transition"
                                    offset-y
                                    max-width="250px"
                                    min-width="250px"
                                >
                                    <template v-slot:activator="{ on }">
                                    <v-text-field
                                        v-model="sampai"
                                        label="Selesai"
                                        @click:minute="$refs.menus.save(sampai)"
                                        readonly
                                        v-on="on"
                                    ></v-text-field>
                                    </template>
                                    <v-time-picker
                                    v-if="menu3"
                                    v-model="sampai"
                                    full-width
                                    @click:minute="$refs.menus.save(sampai)"
                                    ></v-time-picker>
                                </v-menu>
                                </v-col>

                                 <v-col cols="12"  md="6">
                                <v-menu
                                    v-model="awal_pendaftaran"
                                    :close-on-content-click="false"
                                    :nudge-right="40"
                                    transition="scale-transition"
                                    offset-y
                                    min-width="290px"
                                >
                                    <template v-slot:activator="{ on, attrs }">
                                    <v-text-field
                                        v-model="date_pendaftaran_awal"
                                        label="Awal Pendaftaran"
                                       
                                        readonly
                                        v-bind="attrs"
                                        v-on="on"
                                    ></v-text-field>
                                    </template>
                                    <v-date-picker v-model="date_pendaftaran_awal" @input="awal_pendaftaran = false"></v-date-picker>
                                </v-menu>
                                </v-col>

                                <v-col cols="12"  md="6">
                                <v-menu
                                    v-model="akhir_pendaftaran"
                                    :close-on-content-click="false"
                                    :nudge-right="40"
                                    transition="scale-transition"
                                    offset-y
                                    min-width="290px"
                                >
                                    <template v-slot:activator="{ on, attrs }">
                                    <v-text-field
                                        v-model="date_pendaftaran_akhir"
                                        label="Akhir Pendaftaran"
                                        
                                        readonly
                                        v-bind="attrs"
                                        v-on="on"
                                    ></v-text-field>
                                    </template>
                                    <v-date-picker v-model="date_pendaftaran_akhir" @input="akhir_pendaftaran = false"></v-date-picker>
                                </v-menu>
                                </v-col>
                                 <v-col cols="12"  md="6">
                                <v-menu
                                    v-model="start_class"
                                    :close-on-content-click="false"
                                    :nudge-right="40"
                                    transition="scale-transition"
                                    offset-y
                                    min-width="290px"
                                >
                                    <template v-slot:activator="{ on, attrs }">
                                    <v-text-field
                                        v-model="date_start_class"
                                        label="Mulai Class"
                                        
                                        readonly
                                        v-bind="attrs"
                                        v-on="on"
                                    ></v-text-field>
                                    </template>
                                    <v-date-picker v-model="date_start_class" @input="start_class = false"></v-date-picker>
                                </v-menu>
                                </v-col>

                                <v-col cols="12"  md="6">
                                <v-menu
                                    v-model="end_class"
                                    :close-on-content-click="false"
                                    :nudge-right="40"
                                    transition="scale-transition"
                                    offset-y
                                    min-width="290px"
                                >
                                    <template v-slot:activator="{ on, attrs }">
                                    <v-text-field
                                        v-model="date_end_class"
                                        label="Selesai Class"
                                        
                                        readonly
                                        v-bind="attrs"
                                        v-on="on"
                                    ></v-text-field>
                                    </template>
                                    <v-date-picker v-model="date_end_class" @input="end_class = false"></v-date-picker>
                                </v-menu>
                                 </v-col>

                            </v-row>

                             <v-text-field
                            v-model="max_student"

                            label="Max Students"
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
import ClassMixin from '../../mixins/ClassMixin'
export default {
    name: 'Class.create',
    data: () => ({
        imgurl: 'storage/default/icon_admin.jpg',
        foto:''

   }),

    mixins:[ClassMixin],
    methods:{
        async save(){
            this.loading = true
            let url = window.location.pathname
            url = url.split('/')
            url = `${url[1]}/${url[2]}`
            let data = new FormData()
            data.append('_method','PUT')
            data.append('name',this.name)
            data.append('id_courses' , this.courses)
            data.append('id_trainer' , this.trainer)
            data.append('days' , JSON.stringify(this.days))
            data.append('mulai' , this.time)
            data.append('sampai' , this.sampai)
            data.append('max_student' , this.max_student)
             data.append('start_class' , this.date_start_class)
            data.append('end_class' , this.date_end_class)
                 data.append('awal_pendaftaran' , this.date_pendaftaran_awal)
            data.append('akhir_pendaftaran' , this.date_pendaftaran_akhir)
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

        eventChange(){
            let id_category = this.item_courses.find(x => x.id === this.courses)
            let data = this.trainers.filter(x => x.id_category === id_category.id_category)

            this.item_trainers = data
            console.log(data)
        },

        go(){
            let url = window.location.pathname
            this.axios.get(url,this.config)
            .then((ress) => {
                this.item_courses = ress.data.courses
                this.trainers = ress.data.trainers
                this.item_days = ress.data.days

                this.name = ress.data.class.name
                this.courses = ress.data.class.id_courses
                this.eventChange()
                this.trainer = ress.data.class.id_trainer
                this.days = ress.data.class.days
                this.time =  ress.data.class.mulai,
                this.sampai = ress.data.class.sampai
                this.max_student = ress.data.class.max_student
                // this.date_pendaftaran_awal = this.setDate(ress.data.class.awal_pendaftaran)
                // this.date_pendaftaran_akhir = this.setDate(ress.data.class.akhir_pendaftaran)
                 this.date_pendaftaran_awal = ress.data.class.awal_pendaftaran
                this.date_pendaftaran_akhir = ress.data.class.akhir_pendaftaran
                 this.date_start_class = ress.data.class.start_class
                this.date_end_class = ress.data.class.end_class

            })
            .catch((err) => console.log(err.response))
        },
        setDate(value){
        let data = value
        data = new Date(data)
        // let bulan = data.getMonth()
        // let tgl = data.getDate()
        // tgl = tgl.toString().length < 2 ? `0${tgl}` : `${tgl}` 
        // bulan = bulan.toString().length < 2 ? `0${bulan + 1}` : `${bulan + 1}` 
        // data = `${data.getFullYear()}-${bulan}-${tgl}`
        return data
        }

    },

    created(){
        this.go()
    }

}
</script>

<style lang="css" scoped>
/* .v-chip--select{
    background-color: #212121 !important;
    color: white !important;
} */
</style>
