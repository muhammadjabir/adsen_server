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
        max_student:'',
        awal_pendaftaran : false,
        akhir_pendaftaran : false,
        date_pendaftaran_awal: new Date().toISOString().substr(0, 10),
        date_pendaftaran_akhir: new Date().toISOString().substr(0, 10),
        start_class : false,
        end_class : false,
        date_start_class: new Date().toISOString().substr(0, 10),
        date_end_class: new Date().toISOString().substr(0, 10),

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
