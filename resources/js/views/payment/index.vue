<template>
    <v-app>
        <v-container>
            <h2>Redhunter Academy</h2>
            <v-row v-if="status_code == 200">
            
                <v-col
               cols="12"
               md="7"
               >
                <v-card
                outlined
                class="card-payment"
                >
                
                <h2>No Invoice : RH{{customer.kode_invoice}}</h2>
                <hr>
                <p>
                Billed to : 
                </p>
                <span>
                    {{customer.nama}}, {{customer.alamat}} - {{customer.nohp}}
                </span>
                <hr>
                <br>
                <table style="width:100%" class="table">
                    <thead>
                        <tr>
                            <th>Kelas</th>
                            <th>Ketegori Kursus</th>
                            <th>Kursus</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>{{customer.kelas}}</td>
                            <td>{{category_courses}}</td>
                            <td><ul>
                                <li v-for="item in courses" :key="item.name">{{item.name}}</li>
                            </ul></td>
                        </tr>
                    </tbody>
                </table>
                <br>
                <hr>
                <div style="text-align:right; color:black; padding:20px; margin-top:5px; background-color:#f5f5f5">
                    <h3>
                    Total(IDR) {{customer.harga | formatPrice}}
                        
                    </h3>
                </div>
                </v-card>
                
               </v-col>

               <v-col
               cols="12"
               md="5"
               >
               <v-radio-group v-model="virtualBank" class="radio-payment">
                <v-card
                outlined
                class="card-payment"
                v-for="item in virtualAccount.items" :key="item.bank_code" v-show="!choiceBank"
                >
                
                    <v-radio
                    :value="item.payment_method_code"
                    >
                    <template slot="label">
                        <v-img :src="item.logo" style="max-width:120px"></v-img> 
                    </template>
                    </v-radio>
                    
                </v-card>
                <div v-show="choiceBank" >
                    <v-btn block outlined color="red" @click="choiceBank=false" > << Ganti metode pembayaran</v-btn>
                    <br>
                    <v-card
                    outlined
                    class="card-payment"
                    
                    >
                    
                        <v-img :src="imgChoice" style="max-width:200px;margin:auto"></v-img> 
                        <p class="text-center">Virtual Account</p>
                    </v-card>
                </div>
                
                
                </v-radio-group>

                <v-btn :loading="loading" block outlined color="success" :disabled="virtualBank == ''" @click="choiceBank ? create_payment() : choice_bank()">
                    
                    {{choiceBank ? 'Bayar Sekarang' : 'Lanjutakan Pembayaran'}}
                    
                </v-btn>
               </v-col>
                
            </v-row>

            <div v-else-if="status_code == 201">
                <v-card
                outlined
                class="card-payment"
                >
                    <v-img :src="imgChoice" style="max-width:200px;margin:auto"></v-img> 
                    <p class="text-center">Virtual Account</p>
                    <hr>
                    <table class="virtual-success" >
                        <tr>
                            <th>Reference Number</th>
                            <th>{{customer.reference_no}}</th>
                        </tr>

                        <tr>
                            <th>Invoice Number</th>
                            <th>{{customer.invoice_no}}</th>
                        </tr>
                        <tr>
                            <th>Type BANK</th>
                            <th>{{customer.pay_method}}</th>
                        </tr>
                        <tr>
                            <th>Virtual Account Number</th>
                            <th>{{customer.pay_code}}</th>
                        </tr>
                        <tr>
                            <th>Amount</th>
                            <th>Rp. {{customer.amount | formatPrice}}</th>
                        </tr>
                        <tr>
                            <th>Deskripsi</th>
                            <th>{{customer.description}}</th>
                        </tr>
                        <tr>
                            <th>Expired Date</th>
                            <th>{{customer.expired_at}}</th>
                        </tr>

                        <tr>
                            <th>Status</th>
                            <th>{{customer.paid_description}}</th>
                        </tr>
                    </table>
                </v-card>
            </div>
            <div v-else>
                 <v-card
                outlined
                class="pesan-error"
                >
                <h2>{{message}}</h2> 
                </v-card>
                
            </div>
        </v-container>
    </v-app>
</template>
<script>
// import {mapActions} from 'vuex'
export default {
    data() {
        return {
            loading:false,
            virtualBank:'',
            virtualAccount: [],
            choiceBank:false,
            imgChoice:'',
            customer:null,
            courses:[],
            category_courses:'',
            status_code:'',
            message:'Please Wait...',

        }
    },
    name: 'payment.gateway',

   
    methods:{
        get_payment_method() {
            this.axios.get('/payment/method')
            .then((ress) => {
                console.log(ress)
                this.virtualAccount = ress.data.data[0]
            })
            .catch((err) => console.log(err))
        },
        choice_bank(){
            let payment_method = this.virtualBank
            let data = this.virtualAccount.items.find((val) => val.payment_method_code == payment_method)
            this.imgChoice = data.logo
            this.choiceBank = true
        },
        async create_payment() {
            this.loading = true
            const invoice = this.$route.params.invoice 
            let data = new FormData()
            data.append('kode_invoice',invoice)
            data.append('payment_method_code',this.virtualBank)
            await this.axios.post(`/payment/create`,data)
           .then((ress)=>{
               console.log(ress)
               this.status_code = 201
               this.customer = ress.data.data
                let data = this.virtualAccount.items.find((val) => val.payment_method_code == this.customer.pay_method_code)
                this.imgChoice = data.logo

           })
           .catch((err) => {
                this.status_code = err.response.status
                this.message = err.response.data.message
           })
           this.loading = false
        },
        go() {
            const invoice = this.$route.params.invoice
            this.axios.post(`/payment/courses/${invoice}`)
            .then((ress) => {
                console.log(ress)
                this.status_code = ress.status
                if (ress.status == 200) {
                    this.customer = ress.data.customer
                    this.courses = ress.data.courses
                    this.category_courses = ress.data.category_courses
                } else {
                    this.customer = ress.data.data
                    let data = this.virtualAccount.items.find((val) => val.payment_method_code == this.customer.pay_method_code)
                    this.imgChoice = data.logo
                }
                this.status_code = ress.status
            })
            .catch((err) => {
                console.log(err.response)
                this.status_code = err.response.status
                this.message = err.response.data.message
            })
        }
    },

    filters:{
        formatPrice(value) {
        let val = (value/1).toFixed(2).replace('.', ',')
        return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
        }
    },

    async created(){
       
        this.get_payment_method()
        this.go()
        
    }

}
</script>

<style lang="css" scoped>
  .card-payment{
      border-radius: 0px !important;
      padding: 20px 20px 20px 20px;
  }
  .radio-payment {
      margin:0px;
      padding:0px;
  }
  .table {
      border-collapse: collapse;
      
  }
    table, th, td {
    border: 1px solid #efefef;
    }
  .table tr td, .table tr th {
      padding: 20px;
      text-align: left;
  }
 .table tr th {
     background-color:#f5f5f5;
     color: black;
 }
    .pesan-error {
        text-align: center;
        color: black;
        padding: 20px;
    }

.virtual-success {
    margin:auto;
    width:80%;
}
.virtual-success tr th:nth-child(2) {
    width: 50%;
    text-align: left;
}
.virtual-success tr th:first-child {
    width: 50%;
    text-align: right;
}
table.virtual-success, th, td {
    margin-top: 20px;
     padding: 20px;
     border-collapse: collapse;
}
</style>
