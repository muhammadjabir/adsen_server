import {mapActions} from 'vuex'
import middleware from './middleware'
export default {
    data: () => ({
        valid: true,
        lazy:false,
        loading:false,
        select:'',
        items:[],
        name: '',
        harga: 0,
        diskon: 0,
        nameRules: [
          v => !!v || 'Tidak Boleh Kosong',
        ],
      }),
    methods: {
        ...mapActions({
            setSnakbar: 'snakbar/setSnakbar'
        }),
        getCategory(){
            this.axios.get('courses/create',this.config)
            .then((ress) => {
                this.items = ress.data.category
            })
            .catch((err) => console.log(err))
        }

    },

    mixins:[middleware],

    created(){

    }
}
