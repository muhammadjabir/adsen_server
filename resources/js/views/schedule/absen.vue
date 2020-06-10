<template>
    <v-app>
        <v-container>
            <v-row >
                <v-col
                    cols="12"
                    md="8"
                >
                    <BtnJudul text="Class" />
                    <v-card
                    class="border-edit"
                    tile
                    >
                        <v-card-text class="">
                            <v-container>
                                <v-row v-if="kelas !== []">
                                    <v-col
                                    cols="12"
                                    md="4"
                                    >
                                        <v-img style="cursor:pointer" :src="kelas.courses ? kelas.courses.foto_courses : ''" ></v-img>

                                    </v-col>

                                    <v-col>
                                        <v-alert
                                            color="grey darken-4"
                                            border="left"
                                            elevation="1"
                                            colored-border
                                            >
                                            Class Name : <strong>{{kelas.name}}</strong>
                                        </v-alert>

                                        <v-alert
                                            color="grey darken-4"
                                            border="left"
                                            elevation="1"
                                            colored-border
                                            >
                                            Trainer Name : <strong>{{kelas.trainer.name}}</strong>
                                        </v-alert>


                                        <v-alert
                                            color="grey darken-4"
                                            border="left"
                                            elevation="1"
                                            colored-border
                                            >
                                            Time : <strong>{{ kelas.jam_masuk | mencoba }} - {{ kelas.jam_pulang | mencoba }}</strong>
                                        </v-alert>

                                        <v-alert
                                            color="grey darken-4"
                                            border="left"
                                            elevation="1"
                                            colored-border
                                            >
                                            Days : <strong v-for="(value, index) in kelas.hari_masuk" :key="index">
                                                {{value}} {{kelas.hari_masuk.find((x,i) => i === index+1) ? ',' : ''}}
                                            </strong>
                                        </v-alert>


                                    </v-col>
                                </v-row>
                            </v-container>
                        </v-card-text>

                    </v-card>
                </v-col>

                <v-col
                    cols="12"
                    md="4"
                >
                    <BtnJudul text="Students" />
                    <v-card
                    class="border-edit"
                    tile
                    >
                        <v-card-text style="max-height: 400px" class="">
                                <v-list  v-for="(item,index) in students"
                                    :key="index">
                                <v-list-item


                                >
                                    <v-list-item-avatar>
                                    <v-img :src="item.foto_profile"></v-img>
                                    </v-list-item-avatar>

                                    <v-list-item-content>
                                    <v-list-item-title v-text="item.name"></v-list-item-title>
                                    </v-list-item-content>

                                    <v-list-item-action>
                                        <v-checkbox
                                            v-model="item.checkbox"
                                            @change="checkStudent(index)"
                                         >
                                        </v-checkbox>
                                    </v-list-item-action>


                                </v-list-item>
                                <v-divider></v-divider>
                                </v-list>
                           <v-btn color="success" :loading="loading" @click="save()" :disabled="value_student.length === 0" class="mr-3" block  small tile >Save</v-btn>
                        </v-card-text>

                    </v-card>
                </v-col>
            </v-row>

        </v-container>
    </v-app>

</template>
<script>
import BtnJudul from '../../components/external/Btn'
import middleware from '../../mixins/middleware'
import {mapActions} from 'vuex'
export default {
    name: 'trainer',
    data() {
        return {
            kelas:[],
            students:[],
            value_student: [],
            loading:false
        }
    },
    components:{
        'BtnJudul' : BtnJudul
    },
    filters:{
        mencoba: function (value) {
            let jam = value.split(':')
            return `${jam[0]}:${jam[2]}`
        }
    },
    methods:{
        ...mapActions({
            setSnakbar:'snakbar/setSnakbar'
        }),
        checkStudent(i){
            let student = this.students.find((x,index) => index === i)
                if (student.checkbox == true) {
                    this.value_student.push(student.id)

                }else{
                    let index_value = this.value_student.indexOf((student.id))
                    this.value_student.splice(index_value,1)
                }
        },

        async save(){
            this.loading = true
            let url = window.location.pathname
            let data = new FormData()
            data.append('id_student',JSON.stringify(this.value_student))
            await this.axios.post(url,data,this.config)
            .then((ress) =>{
                this.setSnakbar({
                    color:'success',
                    pesan: 'Success Save Data',
                    status:true
                })
            })
            .catch((err)=>{
                console.log(err.response)
                 this.setSnakbar({
                    color:'red',
                    pesan: 'Error',
                    status:true
                })
            })

            this.loading=false
        }
    },
    mixins:[middleware],
    async created() {
        let url = window.location.pathname
        await this.axios.get(url,this.config)
        .then((ress) =>{
            this.kelas = ress.data.kelas
            this.value_student = ress.data.absen
            ress.data.students.forEach(element => {
                let cek = this.value_student.find((x)=> x === element.id)
                // console.log(cek)
                let student = {
                    id : element.id,
                    checkbox: cek ? true : false,
                    foto_profile: element.foto_profile,
                    name: element.name
                }
                this.students.push(student)
            });

        })
        .catch((err) =>console.log(err.response))

        // if (this.value_student !== []){
        //     this.value_student.forEach( data => {
        //         let student = this.students.find((x) => x.id === data.id)
        //         let index = this.students.indexOf((student.id))

        //         console.log(student)
        //         console.log(index)
        //         student.checkbox = true
        //         this.students.splice(index,1,student)
        //     })
        // }
    }

}
</script>

