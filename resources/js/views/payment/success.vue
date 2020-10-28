<template>
    <div>
        <Progress v-if="loading"/>
        <v-card
        width="550px"
        style="margin:auto;margin-top:80px"
        v-if="!loading"
        >

                <v-card-text class="justify-center">
                    <v-row >
                        <v-col cols="12" md="6" class="text-ucapan text-center">
                            <h2>{{message}}</h2>
                        </v-col>
                        <v-col  v-col cols="12" class="text-ucapan" md="6">
                            <v-img width="150px" src="https://redhunter.id/wp-content/uploads/2020/01/maskot_2_thanks.png"/>
                        </v-col>
                    </v-row>
                    
                    
                </v-card-text>
                <v-card-actions>
                <v-spacer></v-spacer>
                </v-card-actions>
        </v-card>
    </div>
   
</template>

<script>
import Progress from '../../components/Progress'
export default {
    data() {
        return {
            message:'',
            loading:true
        }
    },
    components:{
        Progress
    },
    methods:{
        async checkInvoice(){
            let data = new FormData()
            data.append('reference_no',this.$route.query.reference_no)
            data.append('signature',this.$route.query.signature)
            await this.axios.post('/v1/payment/courses',data)
            .then((ress) => {
                this.message = 'Terimakasih telah melakukan pembayaran silakan cek email anda'
            })
            .catch((err) =>{
                this.message = err.response.data.message
            })
            
        }
    },
    async created() {
        await this.checkInvoice()
        this.loading = false
    }
}
</script>

<style scoped>
    .text-ucapan {
        display: flex;
    }
    .text-ucapan h2,.text-ucapan img {
        margin: auto;
    }


</style>
