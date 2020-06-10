export default {
    namespaced:true,
    state : {
        BeforeUrl : null,
        urlDefault : 'http://localhost:8000/'

    },
    mutations : {
        Url : (state , payload) => {
            state.BeforeUrl = payload
        },

    },

    actions : {

        setUrl : ({commit},payload) =>{
            commit('Url',payload)
        },
    },

    getters : {
        url : state => state.BeforeUrl,
        urlDefault: state => state.urlDefault
    }
}
