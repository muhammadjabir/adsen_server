import {mapActions} from 'vuex'
import middleware from './middleware'
import wyswig from './Wyswig'
export default {
    data: () => ({
        valid: true,
        lazy:false,
        loading:false,
        imgulr:'',
        judul: '',
        foto: '',
        deskripsi:'' ,
        nameRules: [
          v => !!v || 'Tidak Boleh Kosong',
        ],
       
      }),
    methods: {
        ...mapActions({
            setSnakbar: 'snakbar/setSnakbar'
        }),
    },

    mixins:[middleware,wyswig],

    created(){

    }
}
