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
        nameRules: [
          v => !!v || 'Tidak Boleh Kosong',
        ],
        password: '',
        passwordRules: [
          v => !!v || 'Tidak Boleh Kosong',
        ],
        email: '',
        emailRules: [
          v => !!v || 'Username is required',
          v => /^\S*$/.test(v) || 'Tidak Boleh Spasi'

        //   v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
        ],
        kelamin:'',
        kelamins:['Pria','Wanita'],
      }),
    methods: {
        ...mapActions({
            setSnakbar: 'snakbar/setSnakbar'
        }),

        getRole(){
            this.axios.get('users/create',this.config)
            .then((ress) => {
                this.items = ress.data.roles
            })
            .catch((err) => console.log(err))
        },

        getCategory(){
            this.axios.get('trainers/create',this.config)
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
