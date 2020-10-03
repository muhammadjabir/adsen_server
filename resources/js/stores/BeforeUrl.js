export default {
    namespaced:true,
    state : {
        BeforeUrl : null,
        urlDefault : `${document.location.origin}` 

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
