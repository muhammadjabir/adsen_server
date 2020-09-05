<template>
    <v-app>
        <Progress v-if="loading"/>
        <v-container v-if="!loading">
            <BtnJudul text="Data Leads" />
            <v-card
            class="border-edit"
            tile
            >
                <v-card-text class="text-center">
                    <v-container>
                        <v-row justify="center" align="center">
                            <v-col
                                cols="6"
                                class="d-flex"
                            >
                            <v-text-field
                                v-model="keyword"
                                label="Pencarian"
                                v-on:keyup = "go"
                                color="grey darken-4"
                                class="mr-2"
                            ></v-text-field>
                            <v-select
                            :items="items"
                            v-model="choice_status"
                            label="Leads Status"
                            @change="filterSelect()"
                            color="grey darken-4"

                            ></v-select>
                            </v-col>

                            <v-col
                                cols="6"
                                align="right"
                            >

                                <v-btn color="primary"  :to="urlcreate" small tile v-if="user.id_role == 23">
                                    Create
                                </v-btn>
                            </v-col>
                        </v-row>
                    </v-container>

                    <v-simple-table>
                        <template v-slot:default>
                        <thead>
                            <tr>
                            <th class="text-left">Nama</th>
                            <th class="text-left">Email</th>
                          
                            <th class="text-left">Pekerjaan</th>
                            <th class="text-left">Kelas dipilih</th>
                            <th class="text-left">Leads Status</th>
                            <th class="text-left">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in data" :key="item.id">
                                <td class="text-left">{{item.nama}}</td>
                                <td class="text-left">{{item.email}}</td>
                                
                                <td class="text-left">{{item.status}}</td>
                                <td class="text-left">{{item.kelas}}</td>
                                <td class="text-left">
                                    <v-btn x-small color="secondary" dark v-if="item.status_pendaftaran == 0 ">Cold Leads</v-btn>
                                    <v-btn x-small color="success" dark v-if="item.status_pendaftaran == 1 ">Leads</v-btn>
                                    <v-btn x-small color="primary" dark v-if="item.status_pendaftaran == 2 ">Hot Leads</v-btn>
                                    <v-btn x-small color="red" dark v-if="item.status_pendaftaran == 3 ">Canceled</v-btn>
                                </td>
                               
                                <td class="text-left">
                                    <v-btn color="primary" v-on:click="showLead(item.id)" small dark v-if="item.status_pendaftaran != 1 || user.id_role == 23">
                                        <v-icon>mdi-circle-edit-outline</v-icon>
                                    </v-btn>
                                    <v-btn color="success" :loading="item.loading" v-on:click="sendInvoice(item.id)" small dark v-if="item.status_pendaftaran != 1 || user.id_role == 23">
                                        Send Invoice
                                    </v-btn>
                                    <!-- <v-btn color="success" v-on:click="edit(item.id)" small dark >
                                        <v-icon>mdi-circle-edit-outline</v-icon>
                                    </v-btn> -->
                                    <v-btn color="error" small @click="dialogDelete(item.id)" v-if="user.id_role == 23">
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

            <v-dialog
            v-model="dialog_leads"
            width="750"
            >
                <v-card>
                    <v-card-title class="grey darken-4 white--text"
          primary-title>Data Lead</v-card-title>

                    <v-card-text>
                        <table class="table-lead">
                            <tbody>
                                <tr>
                                    <td>Nama</td>
                                    <td>{{data_leads.nama}}</td>
                                </tr>

                                <tr>
                                    <td>Tanggal Lahir</td>
                                    <td>{{data_leads.tgl_lahir}}</td>
                                </tr>
                                <tr>
                                    <td>Kelamin</td>
                                    <td>{{data_leads.kelamin}}</td>
                                </tr>
                                <tr>
                                   <td>Email</td>
                                    <td> {{data_leads.email}}</td>
                                </tr>
                                <tr>
                                    <td>Handphone</td>
                                    <td> {{data_leads.nohp}}</td>
                                </tr>
                                    
                                <tr>
                                    <td>Whatsapp</td>
                                    <td> <a :href="'https://api.whatsapp.com/send?phone=' + data_leads.nowareplace +'&text=&source=&data=&app_absent='" target="_blank" rel="noopener noreferrer"> {{data_leads.nowa}}</a></td>
                                </tr>
                                    
                                <tr>
                                    <td>Pertanyaan</td>
                                    <td> {{data_leads.catatan}}</td>
                                </tr>
                                
                                <tr>
                                    <td>Alamat</td>
                                    <td> {{data_leads.alamat}}</td>
                                </tr>
                                <tr>
                                    <td>Dapat Info Dari</td>
                                    <td> {{data_leads.info}}</td>
                                </tr>

                                <tr>
                                    <td>Status</td>
                                    <td > <v-select
                                    :items="items_two"
                                    v-model="change_status"
                                    
                                    @change="gantiStatus(data_leads.id)"
                                    color="grey darken-4"

                                    ></v-select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Kelas</td>
                                    <td > <v-select
                                    v-model="kelas_pilihan"
                                    :items="kelas"
                                    label="Class"
                                    item-text="name"
                                    item-value="id"
                                    @change="gantiStatus(data_leads.id)"
                                    ></v-select>
                                    </td>
                                </tr>
                                
                                <tr v-if="data_leads.followup === undefined || data_leads.followup.length == 0" >
                                    <td >Follow Up</td>
                                    <td v-if="data_leads.followup === undefined || data_leads.followup.length == 0" class="text-followup">
                                        <!-- <input type="text" style="width:100%"> -->
                                        <textarea name="" id="" style="width:100%" v-model="deskripsi"></textarea>
                                        <div class="tombol-save">
                                        <v-btn x-small color="success" @click="followup(data_leads.id)">&#10004;</v-btn>
                                        </div>
                                    </td>
                                </tr>

                                <tr v-for="(item,index) in data_leads.followup" :key="index" v-else>
                                    <td >Follow Up {{index + 1}}</td>
                                    <td  class="text-followup"  >
                                        <!-- <input type="text"> -->
                                        {{ item.id !== undefined ? item.deskripsi : ''}}
                                        <textarea name="" id="" style="width:100%" v-model="deskripsi" v-if="item.id == undefined"></textarea>
                                        <div class="tombol-save">
                                        <v-btn x-small color="success" v-if="deskripsi && item.id == undefined" @click="followup(data_leads.id)" :loading="loading_followup">&#10004;</v-btn>
                                        <v-btn x-small color="success" v-if="index == data_leads.followup.length - 1 && item.id != undefined" @click="tambahFollow()">Follow Up +</v-btn>
                                        </div>
                                    </td>
                                </tr>
                                
                            </tbody>
                        </table>
                    </v-card-text>
                    <v-card-actions>
                    <v-spacer></v-spacer>

                    <v-btn

                        text
                        @click="dialog_leads = false"
                    >
                        Close
                    </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-container>
    </v-app>

</template>
<script>
import CrudMixin from '../../mixins/CrudMixin'
import Pusher from 'pusher-js';
 import Echo from 'laravel-echo';
export default {
    name: 'leads',
    data() {
        return {
            items: [
                'All Status',
                'Cold Leads',
                'Hot Leads',
                'Leads',
                'Cenceled'
            ] ,
            items_two: [
               
                'Cold Leads',
                'Hot Leads',
                'Leads',
                'Cenceled'
            ] ,
            choice_status:'All Status',
            dialog_leads: false,
            change_status:'',
            data_leads:[],
            deskripsi: '',
            loading_followup : false,
            kelas:[],
            kelas_pilihan:''
        }
    },
    mixins:[CrudMixin],
    methods: {
        async filterSelect(){
             switch (this.choice_status) {
                case 'Cold Leads':
                    this.status = 0
                break;

                case 'Hot Leads':
                    this.status = 2
                break;

                case 'Leads':
                    this.status = 1
                break;

                case 'Cenceled':
                    this.status = 3
                break;
            
                default:
                    this.status = ''
                    break;
            }

            this.go()
        },
        async followup(id_calon){
            let data = new FormData()
             this.loading_followup = true
            data.append('id_calon',id_calon)
            data.append('deskipsi',this.deskripsi)
            await this.axios.post('/followup',data,this.config)
            .then((ress)=> {
               
                this.data_leads = ress.data.data
                this.deskripsi = ''
            })
            .catch((err) => {
                console.log(err)
            })
            this.loading_followup = false
        },

        tambahFollow(){
            let data = {
                deskripsi:''
            }
            console.log(this.data_leads.followup)
            this.data_leads.followup.push(data)
        },
        showLead(id){
            this.data_leads = this.data.find( item => {
                return item.id === id
            })
            
            switch (this.data_leads.status_pendaftaran) {
                case 0:
                    this.change_status = 'Cold Leads'
                break;

                case 2 :
                    this.change_status = 'Hot Leads'
                break;

                case 1 :
                    this.change_status = 'Leads'
                break;

                case 3 :
                    this.choice_status = 'Cenceled'
                break;
            
                default:
                    
                    break;
            }
            console.log(this.data_leads.nowa.replace('0','62'))
            this.data_leads.nowareplace = this.data_leads.nowa.replace('0','62')
            this.kelas_pilihan = this.data_leads.id_kelas
            console.log(this.data_leads)
            this.dialog_leads = true

        },
        async gantiStatus(id) {
            let data_status = 0
            switch (this.change_status) {
                case 'Cold Leads':
                    data_status = 0
                break;

                case 'Hot Leads':
                    data_status = 2
                break;

                case 'Leads':
                    data_status = 1
                break;

                case 'Cenceled':
                    data_status = 3
                break;
            
                default:
                    data_status = ''
                    break;
            }
            console.log(data_status)
            await this.axios.get('/ganti-status?id=' + id + '&status=' + data_status + '&kelas='+this.kelas_pilihan,this.config)
            .then((ress)=>{
                this.go()
            })
            .catch((err)=>{
                console.log(err)
            })
        },

        async sendInvoice(id){
            let lead = this.data.find(x => x.id === id)
            let index = this.data.findIndex(x => x.id === id)
            lead.loading = true
            this.data.splice(index,1,lead)
            await this.axios.post(`/send-invoice/${id}/mail`,{},this.config)
            .then((ress)=>{
                this.setSnakbar({
                    color:'success',
                    pesan:'Berhasil Kirim Invoice',
                    status:true
                })
            })
            .catch((err)=>{
               this.setSnakbar({
                    color:'red',
                    pesan:'Terjadi Kesalahan Hubungi Developer',
                    status:true
                })
            })
            lead.loading = false
            this.data.splice(index,1,lead)
        },
        getKelas(){
            this.axios.get('get-kelas',this.config)
            .then((ress) => {
                this.kelas = ress.data.kelas
                console.log(this.kelas)

            })
            .catch((err) => console.log(err))
        },
    
        
    },
    async created(){
        this.getKelas()
         var pusher = new Pusher('fdsfs23424rf', {
        cluster: 'mt1',
        // forceTLS: true,
        broadcaster: 'pusher',
        // key: 'fdsfs23424rf',
        wsHost: window.location.hostname,
        wsPort: 6001,
        // enabledTransports: ['ws', 'wss']
        });
        let fngsi =() => {
            this.go()
        }
        // fngsi()
        var channel = pusher.subscribe('push');
        channel.bind("test.channel", function(data) {
        // app.messages.push(JSON.stringify(data));
        console.log('test')
             fngsi()
        });
       

    //     window.Pusher = require('pusher-js');

    //     window.Echo = new Echo({
    //         // broadcaster: 'pusher',
    //         // key: process.env.MIX_PUSHER_APP_KEY,
    //         // cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    //         // encrypted: true
    //         broadcaster: 'pusher',
    //         key: 'fdsfs23424rf',
    //         wsHost: window.location.hostname,
    //         wsPort: 6001,
    //         enabledTransports: ['ws', 'wss']
           
    //     });
        
    //     window.Echo.connector.pusher.connection.bind('connected', () => {
    //     console.log('connected');
    //     });
        
    //    window.Echo.channel('channel-notif')
    //     .listen('test.channel', (e) => {
    //         console.log('test')
    //     });
    },
    updated() {
        
    },
    mounted(){
        
    }
    

}
</script>
<style scoped>
.table-lead {
    border-collapse: collapse;
    width: 100%;
    margin-top: 20px;
}
    .table-lead td{
        border: 1px solid black;
    }
    .table-lead td {
        padding: 10px 5px 10px 5px;
    }
    .text-followup{
        position: relative;
    }
    .tombol-save{
        position: absolute;
        top: 0px;
        right: 0px;
    }
</style>

