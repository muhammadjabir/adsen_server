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
        username: '',
        nameRules: [
          v => !!v || 'Tidak Boleh Kosong',
        ],
        kelamin:'',
        kelamins:['Pria','Wanita'],
        kelas:[],
        kelas_student:''
      }),
    methods: {
        ...mapActions({
            setSnakbar: 'snakbar/setSnakbar'
        }),

        getKelas(){
            this.axios.get('students/create',this.config)
            .then((ress) => {
                this.kelas = ress.data.kelas
                console.log(this.kelas)

            })
            .catch((err) => console.log(err))
        },
    },

    mixins:[middleware],

    created(){

    }
}
