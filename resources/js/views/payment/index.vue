<template>
    <v-app>
        <v-container>

            <v-row>
                <v-col
               cols="12"
               md="7"
               >
                <v-card
                outlined
                class="card-payment"
                >
                
                <h2>No Invoice</h2>
                <hr>
                <p>
                Billed to : 
                </p>
                <span>
                    Muhammad Jabir, Jl selali dihari - 089232323
                </span>
                <hr>
                <br>
                <table style="width:100%">
                    <thead>
                        <tr>
                            <th>Kelas</th>
                            <th>Courses</th>
                        </tr>
                    </thead>
                </table>
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

                <v-btn block outlined color="success" :disabled="virtualBank == ''" @click="choiceBank ? create_payment() : choice_bank()">
                    
                    {{choiceBank ? 'Bayar Sekarang' : 'Lanjutakan Pembayaran'}}
                    
                </v-btn>
               </v-col>
                
            </v-row>
        </v-container>
    </v-app>
</template>
<script>
// import {mapActions} from 'vuex'
export default {
    data() {
        return {
            virtualBank:'',
            virtualAccount: [],
            choiceBank:false,
            imgChoice:''

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
        create_payment() {

        }
    },

    created(){
        this.get_payment_method()
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
</style>
