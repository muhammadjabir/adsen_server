
import {mapActions, mapGetters} from 'vuex'
import BtnJudul from '../components/external/Btn.vue'
export default {
    data(){
        return {
            config:null
        }
    },

    mounted() {

    },

    computed: {
        ...mapGetters({
            token:'auth/token',
            urlDefault: 'BeforeUrl/urlDefault'
        })
    },

    created(){
        this.config = {
            headers: {
                'Authorization': 'Bearer ' + this.token,
            }
        }
    },
    components:{
        BtnJudul
    }
}
