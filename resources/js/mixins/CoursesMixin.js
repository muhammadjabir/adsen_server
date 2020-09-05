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
        category_courses:[],
        category_course:'',
        link_tokped:'',
        link_bukalapak:''
      }),
    methods: {
        ...mapActions({
            setSnakbar: 'snakbar/setSnakbar'
        }),
        getCategory(){
            this.axios.get('courses/create',this.config)
            .then((ress) => {
                this.items = ress.data.category
                this.category_courses = ress.data.category_courses
            })
            .catch((err) => console.log(err))
        }

    },

    mixins:[middleware],

    created(){

    }
}
