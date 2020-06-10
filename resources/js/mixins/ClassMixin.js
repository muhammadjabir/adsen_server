import {mapActions} from 'vuex'
import middleware from './middleware'
export default {
    data: () => ({
        valid: true,
        lazy:false,
        loading:false,
        courses:'',
        item_courses:[],
        name: '',
        nameRules: [
          v => !!v || 'Tidak Boleh Kosong',
        ],
        trainers:[],
        item_trainers:[],
        trainer:'',
        days:[],
        item_days:[],
        time: null,
        menu2: false,
        sampai: null,
        menu3: false,
        modal2: false,
        max_student:''

      }),
    methods: {
        ...mapActions({
            setSnakbar: 'snakbar/setSnakbar'
        }),
        getData(){
            this.axios.get('class-management/create',this.config)
            .then((ress) => {
                this.item_courses = ress.data.courses
                this.trainers = ress.data.trainers
                this.item_days = ress.data.days
            })
            .catch((err) => console.log(err))
        }

    },

    mixins:[middleware],

    created(){

    }
}
